<?php
namespace App\Libraries\WebSocket;
use App\Libraries\WebSocket\ChatHandler;
    class WebSocket{
        private $socket ;
        private $chat_handler ;
        private const PORT = '1410';
        private const HOSTNAME = '127.0.0.90';
        public function __construct()
        {
            $this->chat_handler = new ChatHandler();
            $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
            socket_bind($this->socket, 0, WebSocket::PORT);
            socket_listen($this->socket);
            echo "test";
        }
        public function test(){
            $clientSocketArray = array($this->socket);
            while (true) {
                $newSocketArray = $clientSocketArray;

                socket_select($newSocketArray, $null, $null, 0, 10);
                if (in_array($this->socket, $newSocketArray)) {
                    $newSocket = socket_accept($this->socket);
                    $clientSocketArray[] = $newSocket;
                    echo "Iam in \n";
                    $header = socket_read($newSocket, 1024);
                    //doing the handshake as usual just to convert the ip
                    $this->chat_handler->doHandshake($header, $newSocket, WebSocket::HOSTNAME, WebSocket::PORT);
                    //socket_getpeername return the address number of the connected socket in client_ip_address
                    socket_getpeername($newSocket, $client_ip_address);


                    $connectionACK = $this->chat_handler->newConnectionACK($client_ip_address);
                    $this->chat_handler->send($connectionACK ,$clientSocketArray);

                    $newSocketIndex = array_search($this->socket, $newSocketArray);
                    unset($newSocketArray[$newSocketIndex]);
                }

                foreach ($newSocketArray as $newSocketArrayResource) {
                    //socket_recv returns the number of bytes it recieved so if the number of bytes bigger that 1 procced
                    while(@socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
                        $socketMessage = $this->chat_handler->unseal($socketData);
                        if($socketMessage){
                            //create chat box is not essential function custome stuff ..
                            $chat_box_message = $this->chat_handler->createChatBoxMessage($socketMessage->chat_user, $socketMessage->chat_message);
                            $this->chat_handler->send($chat_box_message,$clientSocketArray);

                        }

                        break 2;
                    }
                    $socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);

                    if ($socketData === false) {
                        @socket_getpeername($newSocketArrayResource, $client_ip_address);
                        $connectionACK = $this->chat_handler->connectionDisconnectACK($client_ip_address);
                        $this->chat_handler->send($connectionACK ,$clientSocketArray);
                        $newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
                        unset($clientSocketArray[$newSocketIndex]);
                    }
                }
            }
            //closing the socket inside the server
            socket_close($this->socket);

        }
    }
