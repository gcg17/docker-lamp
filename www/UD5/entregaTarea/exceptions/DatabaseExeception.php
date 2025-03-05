<?php
class DatabaseException extends Exception {
    private string $method;
    private string $sql;

    public function __construct($message, $method, $sql, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->method = $method;
        $this->sql = $sql;
    }

    public function getMethod(): string { return $this->method; }
    public function getSql(): string { return $this->sql; }
}
?>
