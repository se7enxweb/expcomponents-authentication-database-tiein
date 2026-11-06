<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 * @subpackage Tests
 */

/**
 * OpenID wrapper whose two provider round trips (associate and
 * check_authentication) answer as the provider of the test fixtures,
 * www.myopenid.com, did. That provider shut down in 2014, so the tests could
 * no longer reach it; everything else (the database store, nonces, stored
 * associations, smart and dumb mode) runs unchanged. Every round trip is
 * recorded in $calls so the tests can assert that it happened.
 *
 * For testing purposes only.
 *
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 * @subpackage Tests
 * @access private
 */
class ezcAuthenticationOpenidReplayProviderWrapper extends ezcAuthenticationOpenidWrapper
{
    /**
     * The round trips made: array( array( 'associate'|'check_authentication', $provider, $params ) ).
     *
     * @var array
     */
    public $calls = array();

    /**
     * The provider answered "is_valid:false" to check_authentication for the
     * fixture signatures (they were made for an association it no longer had).
     */
    public function checkSignature( $provider, array $params, $method = 'GET' )
    {
        $this->calls[] = array( 'check_authentication', $provider, $params );
        return false;
    }

    /**
     * The provider answered an associate request with a new HMAC-SHA1
     * association valid for two weeks (the format of its key-value reply).
     */
    public function associate( $provider, array $params, $method = 'GET' )
    {
        $this->calls[] = array( 'associate', $provider, $params );
        return array(
            'assoc_handle' => '{HMAC-SHA1}{4b6b8f1e}{Q2xvc2Vk}',
            'assoc_type' => 'HMAC-SHA1',
            'expires_in' => '1209600',
            'mac_key' => 'c2VjcmV0IG9mIHRoZSByZXBsYXllZCBhc3NvYw==',
            );
    }
}
?>
