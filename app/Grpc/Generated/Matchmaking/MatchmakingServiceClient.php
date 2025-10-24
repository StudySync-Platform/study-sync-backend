<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Matchmaking;

/**
 */
class MatchmakingServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Matchmaking\MatchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RequestMatch(\Matchmaking\MatchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/matchmaking.MatchmakingService/RequestMatch',
        $argument,
        ['\Matchmaking\MatchResponse', 'decode'],
        $metadata, $options);
    }

}
