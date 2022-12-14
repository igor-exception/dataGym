<?php

namespace Tests\Unit\App\User;

class UserTest extends \PHPUnit\Framework\TestCase
{
    private $name = 'John';
    private $email = 'john.doe@gmail.com';
    private $password = '12345678';
    private $password_confirmation = '12345678';

    /**
     * @dataProvider invalid_names_dataprovider
     */
    public function test_red_name($name, $exception_name): void
    {
        $this->expectException($exception_name);

        $user = new \App\User\User(
            $name,
            $this->email,
            $this->password,
            $this->password_confirmation
        );
    }

    /**
     * @dataProvider valid_names_dataprovider
     */
    public function test_green_name($name)
    {
        $user = new \App\User\User(
            $name,
            $this->email,
            $this->password,
            $this->password_confirmation
        );
        $this->assertInstanceOf(\App\User\User::class, $user);
    }

    /**
     * @dataProvider invalid_emails_dataprovider
     */
    public function test_red_email($email, $exception_name): void
    {
        $this->expectException($exception_name);

        $user = new \App\User\User(
            $this->name,
            $email,
            $this->password,
            $this->password_confirmation
        );
    }

    /**
     * @dataProvider valid_emails_dataprovider
     */
    public function test_green_email($email): void
    {
        $user = new \App\User\User(
            $this->name,
            $email,
            $this->password,
            $this->password_confirmation
        );

        $this->assertInstanceOf(\App\User\User::class, $user);
    }

    /**
     * @dataProvider invalid_passwords_dataprovider
     *
     */
    public function test_red_password($password, $password_confirmation, $exception_name): void
    {
        $this->expectException($exception_name);

        $user = new \App\User\User(
            $this->name,
            $this->email,
            $password,
            $password_confirmation
        );
    }

    /**
     * @dataProvider valid_passwords_dataprovider
     *
     */
    public function test_green_password($password, $password_confirmation): void
    {
        $user = new \App\User\User(
            $this->name,
            $this->email,
            $password,
            $password_confirmation
        );

        $this->assertInstanceOf(\App\User\User::class, $user);
    }

    public function invalid_names_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_empty_name' => ['', \App\Exception\EmptyUserNameException::class],
            'should_get_an_exception_when_using_name_shorter_than_3_chars' => ['Jo', \LengthException::class],
            'should_get_an_exception_when_using_name_bigger_than_255_chars' => [str_repeat('a', 256), \LengthException::class]
        ];
    }

    public function valid_names_dataprovider(): array
    {
        return [
            'should_get_instance_of_object_with_name_not_empty' => ['name' => 'John Doe'],
            'should_get_instance_of_object_with_name_equals_3_chars' => ['name' => 'Joe'],
            'should_get_instance_of_object_with_name_equals_255_chars' => ['name' => str_repeat('a', 255)],
        ];
    }

    public function invalid_emails_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_email_without_@_symbol' => ['john.doe.com', \App\Exception\InvalidEmailFormatException::class],
            'should_get_an_exception_when_using_email_bigger_than_65_chars' => ['66charssssssssssssssssssssssssssssssssssssssssssssssssss@gmail.com', \LengthException::class]
        ];
    }

    public function valid_emails_dataprovider(): array
    {
        return [
            'should_get_an_instance_of_object_when_valid_email' => ['email' => 'john.doe@gmail.com'],
            'should_get_an_instance_of_object_when_valid_email_equals_65_chars' => ['email' => 'john.doeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee@gmail.com'],
        ];
    }

    public function invalid_passwords_dataprovider(): array
    {
        return [
            'should_get_an_exception_when_using_blank_spaces_in_password' => ['password' => 'asd 123 asd', 'password_confirmation' => 'asd 123 asd', 'exception_name' => \App\Exception\InvalidPasswordBlankCharacterException::class],
            'should_get_an_exception_when_using_password_shorter_than_8_chars' => ['password' => 'passwd', 'password_confirmation' => 'passwd', 'exception_name' => \LengthException::class],
            'should_get_an_exception_when_using_password_bigger_than_255_chars' => ['password' => str_repeat('a', 256), 'password_confirmation' => str_repeat('a',256), 'exception_name' => \LengthException::class],
            'should_get_an_exception_when_using_mismatching_password_and_password_confirmation' => ['password' => 'password123', 'password_confirmation' => 'password000', 'exception_name' => \App\Exception\MismatchPasswordException::class]
        ];
    }

    public function valid_passwords_dataprovider(): array
    {
        return [
            'should_get_an_instance_of_object_when_valid_password_and_password_confirmation' => ['password' => '12345678', 'password_confirmation' =>'12345678'],
            'should_get_an_instance_of_object_when_password_equals_255_chars' => ['password' => str_repeat('a', 255), 'password_confirmation' => str_repeat('a',255)],
        ];
    }
}