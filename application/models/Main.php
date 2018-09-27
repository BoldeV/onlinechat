<?php 

namespace application\models;

use application\core\Model;
use DateTime;
use Imagick;

class Main extends Model
{   

    public $error;

    public function clean($value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }
    /*
        проверка длины поля возвращает true в случаи успеха
    */
    public function check_length($value, $min, $max) {
        $bool = (iconv_strlen($value) < $min || iconv_strlen($value) > $max);
        return !$bool;
    }

    public function reg_user($post) {
        $name = $post['name'];
        $name = $this->clean($name);
        if (empty($name)) {
            $this->error = 'пустое поле!';
            return false;
        }
        if (!$this->check_length($name, 4, 15)) {
            $this->error = 'Имя должно быть больше 4 и меньше 15 символов!';
            return false;
        }
        $_SESSION['authorized'] = 1;
        $_SESSION['name'] = $post['name'];
        return true;
    }

    public function validate_message($post) {
        $message = $post['message'];
        $message = $this->clean($message);
        if (empty($message)) {
            $this->error = 'Введите сообщение или картинку';
            return false;
        }
        if (!$this->check_length($message, 10, 500)) {
            $this->error = 'Сообщение должно быть больше 10 и меньше 500 символов!';
            return false;
        }
        return true;
    }

    public function add_message($post, $bool) {
        $date = date("j F G:i");
        $params = [
            'name' => $_COOKIE['name']['name'],
            'message' => $post['message'],
            'date' => $date,
            'img' => $bool,
        ];
        $this->db->query(
            'INSERT INTO `messages` (`id`, `name`, `message`, `likes`, `date`, `img`) VALUES (NULL, :name, :message, 0, :date, :img)',
            $params
        );
        return $this->db->lastInsertId();

    }

    public function get_all_message() {
        return $this->db->row('SELECT * FROM messages ORDER BY id DESC');
    }

    public function get_message($id) {
        $params = [
            'id' => $id,
        ];
        return $this->db->row('SELECT * FROM messages WHERE id = :id', $params);
    }

    public function like_message($id) {
        $params = [
            'id' => $id,
        ];
        $this->db->query(
            'UPDATE messages SET likes =(`likes` + 1) WHERE id = :id',
            $params
        );
        echo $this->db->row(
            'SELECT likes FROM messages WHERE id = :id',
            $params
        )[0]['likes'];
    }

    public function delete_message($id) {
        $params = [
            'id' => $id,
        ];
        $this->db->query(
            'DELETE FROM messages WHERE id = :id;',
            $params
        );
        exit(json_encode([
            'id' => $id
        ]));
    }

    public function logout() {
        unset($_SESSION['authorized']);
        unset($_SESSION['name']);
        setcookie ("name[bool]", "", time() - 3600);
        setcookie ("name[name]", "", time() - 3600);
    }

    // public function upload_image($path, $id) {
    //     $img = new Imagick($path);
    //     $img->cropThumbnailImage(550,400);
    //     $img->setImageCompressionQuality(80);
    //     $img->writeImage('../public/images/'.$id.'.jpg');
    // }
}