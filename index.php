<?php

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Получаем данные из POST-запроса
        $data = json_decode(file_get_contents('php://input'), true);

        eval($data['functionBody']);

        // Отправляем ответ
        echo json_encode(callFunction($data['functionName'], $data['arguments']));
    } catch (Exception $error) {
        echo json_encode(['error' => "Ошибка в теле функции"]);
    }
} else {
    // Если не POST-запрос, возвращаем ошибку
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
}

function callFunction(callable $function, array $args)
{
    return $function(...$args);
}
