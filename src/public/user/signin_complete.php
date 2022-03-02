<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseInteractor\SignInInteractor;

session_start();
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if (empty($email) || empty($password)) {
    $_SESSION['errors'][] = 'パスワードとメールアドレスを入力してください';
    Redirect::handler('./signin.php');
}

$userEmail = new Email($email);
$inputPassword = new InputPassword($password);
$useCaseInput = new SignInInput($userEmail, $inputPassword);
$useCase = new SignInInteractor($useCaseInput);
$useCaseOutput = $useCase->handler();

if ($useCaseOutput->isSuccess()) {
    Redirect::handler('../index.php');
} else {
    $_SESSION['errors'][] = $useCaseOutput->message();
    Redirect::handler('./signin.php');
}
