<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../lib/PHPMailer.php');
include_once($filepath . '/../lib/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
/**
 * 
 */
class user
{
	private $db;
	public function __construct()
	{
		$this->db = new Database();
	}

	public function login($email, $password)
	{
		$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1 ";
		$result = $this->db->select($query);
		if ($result) {
			$value = $result->fetch_assoc();
			Session::set('user', true);
			Session::set('userId', $value['id']);
			Session::set('role_id', $value['role_id']);
			header("Location:index.php");
		} else {
			$alert = "Tên đăng nhập hoặc mật khẩu không đúng!";
			return $alert;
		}
	}

	public function get()
{
    $userId = Session::get('userId');
    $query = "SELECT * FROM users WHERE id = '$userId' LIMIT 1";
    $mysqli_result = $this->db->select($query);
    
    if ($mysqli_result) {
        $result = mysqli_fetch_assoc($mysqli_result);
        return $result;
    }

    return false;
}


	public function getAllUsers($page = 1, $total = 8)
	{
		if ($page <= 0) {
            $page = 1;
        }
        $tmp = ($page - 1) * $total;
		$query = "SELECT * FROM users";
		$result = $this->db->select($query);
		if ($result) {
			return mysqli_fetch_all($result, MYSQLI_ASSOC);
		}
		return false;
	}
	public function getLastUserId()
	{
		$query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
			return $result;
		}
		return false;
	}
	public function insert($data)
	{
		$fullName = $data['fullName'];
		$email = $data['email'];
		$dob = $data['dob'];
		$address = $data['address'];
		$password = md5($data['password']);
		$check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result_check = $this->db->select($check_email);

		if ($result_check) {
			return 'Email đã tồn tại!';
		} else {
			// Genarate captcha
			$captcha = rand(10000, 99999);

			$query = "INSERT INTO users VALUES (NULL,'$email','$fullName','$dob','$password',2,1,'$address',0,'" . $captcha . "') ";
			$result = $this->db->insert($query);
			if ($result) {
				// Send email
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Mailer = "smtp";
				$mail->SMTPDebug  = 0;
				$mail->SMTPAuth   = TRUE;
				$mail->SMTPSecure = "ssl";
				$mail->Port       = 465;
				$mail->Host       = "smtp.gmail.com";
				$mail->Username   = "cavaldos1211@gmail.com";
				$mail->Password   = "neucfqgtquxatwwu";

				$mail->IsHTML(true);
				$mail->CharSet = 'UTF-8';
				$mail->AddAddress($email, "recipient-name");
				$mail->SetFrom("cavaldos1211@gmail.com", "RabbitStore");
				$mail->Subject = "Xác nhận email tài khoản - RabbitStore";
				$mail->Body = "<h3>Cảm ơn bạn đã đăng ký tài khoản tại website RabbitStore</h3></br>Đây là mã xác minh tài khoản của bạn: " . $captcha . "";

				$mail->Send();
				var_dump($mail->ErrorInfo);
				return true;
			} else {
				return false;
			}
		}
	}

	public function create($data)
	{
		$email = $data['email'];
		$fullName = $data['name'];
		$password = md5($data['password']);
		$role_id = $data['role_id'];
		$status = $data['status'];
		$address = $data['address'];
		$check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result_check = $this->db->select($check_email, [$email]);

		if ($result_check) {
			return ['success' => false, 'message' => 'Email đã tồn tại!'];
		} else {
			$query = "INSERT INTO users VALUES (NULL,'$email','$fullName', NOW(),'$password','$role_id',$status,'$address',0,'')";
			$result = $this->db->insert($query);

			if ($result) {
				return ['success' => true, 'message' => 'Người dùng đã được tạo thành công.'];
			} else {
				return ['success' => false, 'message' => 'Có lỗi xảy ra khi tạo người dùng.'];
			}
		}
	}

	public function edit($userId, $data)
	{

		$query = "SELECT * FROM users WHERE id = '$userId' LIMIT 1";
		$existingUserData = $this->db->select($query);

		if (!$existingUserData) {
			return ['success' => false, 'message' => 'Người dùng không tồn tại.'];
		}                                                                            
		$existingUserData = $existingUserData->fetch_assoc();
		$data['name'] = !empty($data['name']) ? $data['name'] : $existingUserData['fullName'];
		$data['email'] = !empty($data['email']) ? $data['email'] : $existingUserData['email'];
		$data['dob'] = !empty($data['dob']) ? $data['dob'] : $existingUserData['dob'];
		$data['address'] = !empty($data['address']) ? $data['address'] : $existingUserData['address'];
		$fullName = $data['name'];
		$email = $data['email'];
		$dob = $data['dob'];
		$address = $data['address'];
		$checkEmailQuery = "SELECT * FROM users WHERE email='$email' AND id != '$userId' LIMIT 1";
		$resultCheckEmail = $this->db->select($checkEmailQuery);

		if ($resultCheckEmail) {
			return ['success' => false, 'message' => 'Email đã tồn tại!'];
		} else {
			$updateQuery = "UPDATE users SET 
                        email='$email',
                        fullName='$fullName',
                        dob='$dob',
                        address='$address'
                        WHERE id = '$userId'";

			$result = $this->db->update($updateQuery);

			if ($result) {
				return ['success' => true, 'message' => 'Thông tin người dùng đã được cập nhật thành công.'];
			} else {
				return ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật thông tin người dùng.'];
			}
		}
	}



	public function confirm($userId, $captcha)
	{
		$query = "SELECT * FROM users WHERE id = '$userId' AND captcha = '$captcha' LIMIT 1";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$sql = "UPDATE users SET isConfirmed = 1 WHERE id = $userId";
			$update = $this->db->update($sql);
			if ($update) {
				return true;
			}
		}
		return 'Mã xác minh không đúng!';
	}
	private function checkOrderDependency($userId)
	{
		$query = "SELECT COUNT(*) AS orderCount FROM orders WHERE userId = '$userId'";
		$result = $this->db->select($query);

		if ($result) {
			$orderCount = mysqli_fetch_assoc($result)['orderCount'];
			return ($orderCount > 0);
		}

		return false;
	}

	public function delete($userId)
	{
		$orderDependencyCheck = $this->checkOrderDependency($userId);

		if ($orderDependencyCheck) {
			return 'Cannot delete user. There are related orders.';
		}
		$query = "DELETE FROM users WHERE id = '$userId'";
		$result = $this->db->delete($query);

		if ($result) {
			return true;
		} else {
			return false;
		}
	}
}
?>