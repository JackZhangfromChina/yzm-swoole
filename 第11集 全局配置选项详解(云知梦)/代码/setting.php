<?php/** * setting.php * * github.com/farwish/swoole-wholly * * @author ercom */$serv = new Swoole\Http\Server('0.0.0.0', 7749);$serv->set([    'reactor_num'   => 1, // CPU核数*2, 必须小于或等于worker_num    'worker_num'    => 2, // 业务同步阻塞: 1请求50ms 那么单进程qps=100，4进程400qps; 业务异步非阻塞，设置为CPU * 1~4    //'max_request'   => 5000, // (默认0) 只能用于同步阻塞程序, 纯异步Server不应设置; Base模式时，该参数无效    //'max_conn'      => 10000, // 未设置时，ulimit -n 将作为缺省设置; 当 ulimit -n > 10000 时，将默认设置为 10000; 内存一次性分配    'task_worker_num' => 1, // 启用必须设置 onTask, onFinish 回调; task 进程内不能使用task方法 和 异步IO函数    'task_ipc_mode' => 1, // (默认1, unix socket), 消息队列指定key，那么程序终止，数据不会删除; 消息队列模式中的2支持定向投递, 3为争抢模式    'task_max_request' => 5000, // (默认0)    'task_tmpdir' => '/tmp', // task 数据临时目录，默认/tmp    //'task_enable_coroutine' => true, // 开启后自动在 onTask 回调中创建协程，可以使用协程API; 必须在enable_coroutine=true(默认开启)时可用    'dispatch_mode' => 3, // 无状态server可以使用1、3，同步阻塞使用3，异步非阻塞使用1; 有状态使用 2、4、5; SWOOLE_BASE 模式下无效，直接在当前进程回调onReceive，不需要投递worker进程    //'message_queue_key' => 't-', // 消息队列的key，server程序结束不会销毁，重启后task仍会继续处理，使用 ipcrm -q [key] 删除消息队列    //'daemonize'     => 0, // 默认false，守护进程后标准输出到 log_file，未设置时为 /dev/null; 使用systemd、supervisord 管理swoole时，勿设置为1    //'backlog'       => 128, // listen队列长度，决定最多同时有多少个等待accept的连接    //'log_file' => '/data/logs/swoole.log', // swoole错误日志路径，daemon模式使用; 不会自动切分文件,需手动清理    'log_level' => 4, // server错误日志打印等级，范围 0~5, DEBUG/TRACE/INFO/NOTICE/WARNING/ERROR/NONE    //'heartbeat_check_interval' => 60, // 启用心跳检测每隔多少秒轮询一次; 仅支持TCP连接，仅检测连接上一次发送数据的时间，超过限制则断开连接    //'heartbeat_idle_time' => 600, // 连接最大允许空闲时间, 一个连接如果指定秒数内未向服务器发送任何数据，此连接将被强制关闭    //'open_eof_check' => 'true', // 打开EOF检测，检测数据包结尾是指定字符时才投递给worker进程，配置仅对 stream 类型的 socket 有效，如TCP、UnixSocket    //'open_eof_split' => 'true', // 启用自动分包，底层会从数据包中间查找EOF，并拆分数据包，onReceive每次仅收到一个以EOF字串结尾的数据包; 优先级高于 open_eof_check    //'package_eof' => '\r\n', // 设置EOF字符串,最大允许8字节    //'open_length_check' => true, // 打开包长检测特性，提供了固定包头+包体这种格式的协议解析，可以保证worker进程onReceive每次都收到一个完整的数据包    //'package_length_type' => 'N', // 长度值的类型，接受一个字符参数，与 php 的 pack 函数一致    //'package_body_offset' => 0, // 从第几个字节开始计算长度    //'package_length_offset' => xx, // length 长度值在包头的第几个字节    //'package_length_func' => '', // 设置长度解析函数    'package_max_length' => 2*1024, // 一个数据包最大允许占用的内存尺寸，单位为字节    //'open_cpu_affinity' => xx, // 启用CPU亲和性设置,启用此特性会将swoole的reactor线程/worker进程绑定到固定的一个核上, 提高CPU Cache命中率    //'cpu_affinity_ignore' => '', // 接受一个数组作为参数，array(0, 1) 表示不使用CPU0,CPU1，专门空出来处理网络中断; 必须与open_cpu_affinity同时设置才会生效    'open_tcp_nodelay' => true, // 启用后，TCP连接发送数据会关闭Nagle合并算法，立即发往客户端连接，适用实时性高场合; 默认发送数据采用Nagle算法，提高了网络吞吐量    'tcp_defer_accept' => 5, // 启用此特性设置一个数值秒数，表示当一个TCP连接有数据发送时才触发 accept，可以提高 accept 的效率    //'ssl_cert_file' => __DIR__ . '/conf/ssl.crt', // 设置SSL隧道加密，值为文件名绝对路径; 文件必须为 PEM 格式，swoole 编译需要开启 --enable-openssl    //'ssl_key_file'  => __DIR__ . '/conf/ssl.key', // key 私钥路径    //'ssl_method' => SWOOLE_SSLv3_CLIENT_METHOD, // 设置OpenSSL 隧道加密的算法，Server 与 Client 算法必须一致，默认为 SWOOLE_SSLv3_CLIENT_METHOD, 支持类型参考 SWOOLE预定义常量    //'ssl_ciphers' => 'EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH', // 设置改变 openssl 默认的加密算法, swoole 默认使用 EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH    //'user' => 'apache', // 设置 worker/taskWorker 子进程所属用户，仅在使用 root 用户启动时有效; 将工作进程设置为普通用户后，无法在工作进程调用 shutdown/reload 方法关闭或重启服务    //'group' => 'www-data', // 设置 worker/taskWorker 子进程的进程用户组，提升服务器程序安全性; 仅在使用 root 用户启动时有效    //'chroot' => '/data/server/', // 重定向 worker 进程的文件系统根目录，使用 chroot 之后，系统的目录结构将以指定的位置作为 / 位置，新根下访问不到旧系统的根目录结构和文件，增强了系统安全性    'pid_file' => __DIR__ . '/swoole.pid', // Server 启动时将 master 进程pid 写入到文件，关闭时自动删除; 如果 Server 非正常结束, PID文件不会被删除，需要使用 swoole_process::kill($pid, 0) 侦测进程是否存在    //'pipe_buffer_size' => 32 * 1024 * 1024, // 1.9.16或更高版本已移除此配置项，底层不再限制管道缓存区的长度    //'buffer_output_size' => 2 * 1024 * 1024, // 配置发送输出缓存区内存尺寸(字节)，默认为 2M; 调用 Server->send, Http\Server->end/write, WebSocket\Server->push 发送数据，单次不得超过配置值; 不应调整过大，避免拥塞数据过多导致占光内存，开启大量worker，将会占用 worker_num * buffer_output_size 字节的内存    //'socket_buffer_size' => 2 * 1024 * 1024, // 配置客户端连接缓存区长度，最大允许占用内存，默认为 2M; 服务器有大量TCP连接时，最差的情况下将占用 server->max_connection * socket_buffer_size 字节内存    //'enable_unsafe_event' => false, // Swoole 在 dispatch_mode=1或3，默认关闭了 onConnect/onClose 事件，如果应用程序需要这两个事件，并且能接受顺序问题可能带来的风险，可以设置为 ture 启用 onConnect/onClose 事件    //'discard_timeout_request' => true, // Swoole 在 dispatch_mode=1或3 时，系统无法保证 onConnect/onReceive/onClose 的顺序，可能会有一些请求数据在连接关闭后才能到达 worker 进程，默认为 ture 表示自动丢弃; 设置为 false 表示无论连接是否关闭，worker 进程都会处理数据请求    'enable_reuse_port' => true, // 设置端口重用，用于优化 TCP 连接的 accept 性能，启用后多个进程可以同时进行 accept 操作; 仅在Linux-3.9.0以上版本的内核可用; 启用端口重用后可以重复启动同一个端口的Server程序    //'enable_delay_receive' => false, // 设置为true后，accept 客户端连接后将不会自动加入 EventLoop, 仅触发 onConnect 回调; worker进程可以用 $serv->confirm($fd) 对连接进行确认，此时才会将 fd 加入 EventLoop 开始进行数据收发，也可以调用 $serv->close($fd) 关闭此连接    //'open_http_protocol' => true, // 启用 HTTP 协议处理, Swoole\Http\Server 会自动启用此选项，设置为 false 表示关闭 http 协议处理    //'open_http2_protocol' => true, // 启用 HTTP2 协议解析，需要依赖 --enable-http2 选项，默认 false    //'open_websocket_protocol' => true, // 启用 websocket 协议处理，Swoole\WebSocket\Server 会自动启用此选项，设置为 false 表示关闭 websocket 协议处理; 开启后会自动设置 open_http_protocol 也为 true    //'open_mqtt_protocol' => true, // 启用 mqtt 协议处理，启用后会解析 mqtt 包头，worker 进程 onReceive 每次都会返回一个完整的 mqtt 数据包    //'open_websocket_close_frame' => true, // 启用 websocket 协议中关闭帧(opcode 为 0x08 的帧)，在 onMessage 回调中接收，默认为 false    //'reload_async' => true, // 设置异步重启开关，设置为 true 时，将启用异步安全重启特性; worker 进程会等待异步事件完成后再退出    'tcp_fastopen' => true, // 开启 TCP 快速握手特性，此特性可以提升 TCP 短连接的响应速度; 在客户端完成握手的第三步，发送 SYN 包时携带数据    //'request_slowlog_file' => '/tmp/trace.log', // 开启请求慢日志; 启用后 manager 进程会设置一个时钟信号，定时侦测所有 Task 进程(默认)，通过增加 trace_event_worker=>true 来开启对 worker 进程的追踪, 一旦进程阻塞导致请求超过规定的时间，将自动打印进程的 PHP 函数调用栈; 仅在同步阻塞的程序中有效，必须具有可写权限    //'request_slowlog_timeout' => 2, // 设置请求超时时间秒    //'trace_event_worker' => true, // 跟踪 Task 和 Worker 进程    'enable_coroutine' => true, // 默认为true，底层自动在 onRequest 回调中创建协程，开发者无需使用 go 函数创建协程; 通过设置为 false 可关闭内置协程，开发者依然可以使用 go 函数手动创建协程    'max_coroutine' => 3000, // 设置当前工作进程最大协程数量(默认3000)，Server 实际最大可创建协程数量等于 worker_num * max_coroutine    //'ssl_verify_peer' => true, // 服务SSL设置验证对端整数(默认关闭，即不验证客户端证书)，若开启必须同时设置 ssl_client_cert_file 选项    //'ssl_allow_self_signed' => true, // 允许自签名证书    //'ssl_client_cert_file' => __DIR__ . '/config/client.cert', // 客户端证书    'max_wait_time' => 30, // Worker 进程收到停止服务通知后最大等待多长时间，默认30秒; 碰到由于 worker 阻塞卡住导致无法正常 reload，加入进程重启超时时间，超过会强制杀掉后重新拉起    //======= http server 配置选项 ========    'upload_tmp_dir'    => '/tmp/uploads', // 设置文件上传临时目录    'http_parse_post'   => true, // 设置POST消息解析开关    'http_parse_cookie' => true,    'http_compressiona' => true, // 启用压缩，默认为开启    //'document_root'     => '', // 配置静态文件根目录, 与 enable_static_handler 配合使用    //'enable_static_handler' => true, // 开启静态文件请求处理功能，需配合 document_root 使用    //'static_handler_locations' => ['/static'], // 设置静态处理器的路径，数组类型，默认不启用]);