<?php

namespace CustomerIO;

use GuzzleHttp\Client;

/**
 * Description of CustomeIOClient
 *
 * @author Alex Jose
 */
class CustomerIOClient extends Client {

    public function __construct(array $config = array()) {

        if (!isset($config['base_uri'])) {
            $config['base_uri'] = "https://track.customer.io/api/v1/";
        }

        if (!isset($config['site_id']) || !isset($config['api_key'])) {
            throw new \InvalidArgumentException('Customer.io Site ID and API Key is required');
        }

        $config['auth'] = [
            $config['site_id'],
            $config['api_key']
        ];

        $config['verify'] = false;

        unset($config['site_id']);
        unset($config['api_key']);

        parent::__construct($config);
    }

    public function updateCustomer($id, $attributes = array()) {
        if (!isset($attributes['email'])) {
            throw new \InvalidArgumentException('Email field required');
        }
        return $this->put('customers/' . $id, ['json' => $attributes]);
    }

    public function deleteCustomer($id) {
        return $this->delete('customers/' . $id);
    }

    public function createEvent($customer_id, $name, array $attributes = array()) {
        if (empty($name)) {
            throw new \InvalidArgumentException('Event name cannot be blank');
        }

        $data['name'] = $name;
        if (!empty($attributes)) {
            $data['data'] = $attributes;
        }

        return $this->post('customers/' . $customer_id . '/events', ['json' => $data]);
    }

}
