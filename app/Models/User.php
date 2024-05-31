<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['email', 'password'];
    protected $useTimestamps = false;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function verifyPassword(string $rawPassword, string $hashedPassword): bool
    {

        return password_verify($rawPassword, $hashedPassword);
    }

    public function authenticate(string $email, string $password): ?array
    {
        echo'2';
        $user = $this->where('email', $email)->first();

        if ($user && $this->verifyPassword($password, $user['password'])) {
            echo'4';

            return $user;
        }
        echo'5';

        return null;
      
    }
    
}
