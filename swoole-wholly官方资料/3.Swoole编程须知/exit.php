<?php
/**
 * exit.php
 *
 * github.com/farwish/swoole-wholly
 *
 * @author ercom
 */

// 网络客户端/睡眠函数协程化
Swoole\Runtime::enableCoroutine(true);

$server = new Swoole\Server("0.0.0.0", 7749);

// 单工作进程
$server->set([
    'worker_num' => 1,
]);

$server->on("Receive", function ($server, $fd, $reactorId, $data) {
    try {
        // 验证有没有接收到客户端请求
        $server->send($fd, "aaaa\n");

        // 睡眠
        sleep(5);

        throw new \Exception('aaa');

        $server->send($fd, "Swoole: {$data}\n");

    } catch (\Throwable $e) {
        echo $e->getMessage() . ' ! ' . PHP_EOL;
    }
});

$server->start();
