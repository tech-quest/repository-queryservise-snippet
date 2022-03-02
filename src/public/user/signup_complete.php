<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\UseCase\UseCaseInput\SignUpInput;
use App\UseCase\UseCaseInteractor\SignUpInteractor;

$email = filter_input(INPUT_POST, 'email');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

session_start();
if (empty($password) || empty($confirmPassword)) {
    $_SESSION['errors'][] = 'パスワードを入力してください';
}
if ($password !== $confirmPassword) {
    $_SESSION['errors'][] = 'パスワードが一致しません';
}

if (!empty($_SESSION['errors'])) {
    $_SESSION['user']['name'] = $userName;
    $_SESSION['user']['email'] = $email;
    Redirect::handler('./signup.php');
}

$userName = new UserName($userName);
$userEmail = new Email($email);
$userPassword = new InputPassword($password);
$useCaseInput = new SignUpInput($userName, $userEmail, $userPassword);
$useCase = new SignUpInteractor($useCaseInput);
$useCaseOutput = $useCase->handler();

if ($useCaseOutput->isSuccess()) {
    $_SESSION['message'] = $useCaseOutput->message();
    Redirect::handler('./signin.php');
} else {
    $_SESSION['errors'][] = $useCaseOutput->message();
    Redirect::handler('./signup.php');
}
