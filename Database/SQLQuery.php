<?php
class SQLQuery
{
    const HOST = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = '';
    const DBNAME = 'db_name';

    /**
     * Tạo kết nối với cơ sở dữ liệu
     * @return PDO $connect
     */
    private static function Connect()
    {
        try {
            $connect = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DBNAME . ';charset=utf8mb4', self::USERNAME, self::PASSWORD, [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            return $connect;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Sử dụng để tạo một cơ sở dữ liệu mới
     * @param string $dbName Tên của cơ sở dữ liệu
     */
    public static function CreateDB($dbName)
    {
        try {
            $connect = new PDO('mysql:host=' . self::HOST, self::USERNAME, self::PASSWORD, [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            $connect->exec('CREATE DATABASE ' . $dbName);
            $connect = null;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Sử dụng cho câu truy vấn SELECT
     * @param string $query Câu truy vấn
     * @param array $format Định dạng kết quả trả về.
     * $format = ['row' => int, 'cell' => int|string]
     * @return array $arr
     */
    public static function GetData($query, $format = [])
    {
        try {
            if (is_array($format)) {
                $connect = self::Connect();
                $statement = $connect->prepare($query);

                if (isset($format['params'])) {
                    foreach ($format['params'] as $param => $value) {
                        $statement->bindParam($param, $value);
                    }
                }

                $statement->execute();

                $arr = [];
                if ($statement->setFetchMode(PDO::FETCH_ASSOC)) {
                    foreach ($statement->fetchAll() as $key => $value) {
                        $arr[] = $value;
                    }

                    if (isset($format['cell'])) {
                        $formatRow = isset($format['row']) ? $format['row'] : 0;
                        $formatKey = is_numeric($format['cell']) ? array_keys($arr[$formatRow])[$format['cell']] : $format['cell'];
                        return isset($formatRow) ? $arr[$formatRow][$formatKey] : $arr[0][$formatKey];
                    }

                    if (isset($format['row'])) {
                        return $arr[$format['row']];
                    }
                }
                $connect = null;
                return $arr;
            }
            return [];
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Sử dụng cho câu truy vấn SELECT có tính năng phân trang
     * @param string $query Câu truy vấn
     * @param int $page Trang hiện tại là số mấy
     * @param int $offset Số lượng object cho một trang
     * @return array $arr
     */
    public static function GetDataWithPagination($query, $page = 1, $offset = 10, $params = [])
    {
        try {
            $countQuery = 'SELECT COUNT(*) FROM (' . $query . ') AS total';
            $connect = self::Connect();
            $countStatement = $connect->prepare($countQuery);
            foreach ($params as $key => $value) {
                $countStatement->bindValue($key, $value);
            }
            $countStatement->execute();
            $countAll = $countStatement->fetchColumn();

            $start = ($page - 1) * $offset;
            $dataQuery = $query . ' LIMIT :start, :offset';
            $dataStatement = $connect->prepare($dataQuery);

            foreach ($params as $key => $value) {
                $dataStatement->bindValue($key, $value);
            }
            $dataStatement->bindValue(':start', $start, PDO::PARAM_INT);
            $dataStatement->bindValue(':offset', $offset, PDO::PARAM_INT);
            $dataStatement->execute();

            $data = $dataStatement->fetchAll(PDO::FETCH_ASSOC);
            $end = $start + count($data);

            return [
                'data'        => $data,
                'start'       => $start + 1,
                'end'         => $end,
                'countAll'    => $countAll,
                'page_number' => ceil($countAll / $offset),
            ];
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Dùng cho truy vấn INSERT, UPDATE, DELETE
     * @param string $query Câu truy vấn
     * @return int Số lượng bản ghi thay đổi thành công
     */
    public static function NonQuery($query, $params = [])
    {
        try {
            $connect = self::Connect();
            $statement = $connect->prepare($query);

            if (!empty($params)) {
                foreach ($params as $param => $value) {
                    $statement->bindParam($param, $value);
                }
            }

            $statement->execute();
            $connect = null;
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
