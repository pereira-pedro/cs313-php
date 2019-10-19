<?php
class DB
{
    private $conn;

    function __construct()
    {
        $this->conn = $this->connect_db();
    }

    public function getConnection($reconnect = true)
    {
        if ($reconnect) {
            $this->conn = $this->connect_db();
        }

        return $this->conn;
    }

    /**
     * This function connect to Heroku database
     */
    private function connect_db()
    {
        $db_info = parse_url(getenv("DATABASE_URL"));

        $db = new PDO("pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
            $db_info["host"],
            $db_info["port"],
            $db_info["user"],
            $db_info["pass"],
            ltrim($db_info["path"], "/")
        ));

        // this line makes PDO give us an exception when there are problems,
        // and can be very helpful in debugging! (But you would likely want
        // to disable it for production environments.)
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}