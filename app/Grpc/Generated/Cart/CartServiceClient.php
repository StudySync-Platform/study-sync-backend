<?php
// GENERATED CODE -- DO NOT EDIT!

namespace App\Grpc\Generated\Cart;

/**
 */
class CartServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \App\Grpc\Generated\Cart\AddToCartRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddToCart(\App\Grpc\Generated\Cart\AddToCartRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/cart.CartService/AddToCart',
        $argument,
        ['\App\Grpc\Generated\Cart\CartResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \App\Grpc\Generated\Cart\GetCartRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCart(\App\Grpc\Generated\Cart\GetCartRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/cart.CartService/GetCart',
        $argument,
        ['\App\Grpc\Generated\Cart\CartItemsResponse', 'decode'],
        $metadata, $options);
    }

}
