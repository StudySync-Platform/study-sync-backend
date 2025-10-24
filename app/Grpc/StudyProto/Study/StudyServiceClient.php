<?php
// GENERATED CODE -- DO NOT EDIT!

namespace App\Grpc\StudyProto\Study;

/**
 */
class StudyServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \App\Grpc\StudyProto\Study\StudyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetStudySession(\App\Grpc\StudyProto\Study\StudyRequest $argument,
                                                                            $metadata = [], $options = []) {
        return $this->_simpleRequest('/study.StudyService/GetStudySession',
        $argument,
        ['\App\Grpc\StudyProto\Study\StudyResponse', 'decode'],
        $metadata, $options);
    }

}
