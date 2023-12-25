<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../classes/cart.php');
?>



<?php
/**
 * 
 */
class orderDetails
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getOrderDetails($orderId)
    {
        $query = "SELECT od.*,  u.id as userId, u.address
                  FROM order_details od
                  JOIN orders o ON od.orderId = o.id
                  JOIN users u ON o.userId = u.id
                  WHERE od.orderId = $orderId";

        $mysqli_result = $this->db->select($query);

        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC);
            return $result;
        }

        return false;
    }
}
?>
