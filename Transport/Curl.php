<?php
/**
 * Description of Curl
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Transport;

class Curl
{
    const METHOD_GET = 0x01;
    const METHOD_POST = 0x02;
    const METHOD_PUT = 0x04;
    const METHOD_DELETE = 0x08;
    const METHOD_HEAD = 0x10;

    const METHOD_DEFAULT = self::METHOD_GET;

    /**
     * cURL handle
     *
     * @var handle
     */
    private $handle;
    /**
     * Url
     *
     * @var string
     */
    private $url;
    /**
     * Standard cURL options
     *
     * @var array
     */
    private $options = array(
        CURLOPT_RETURNTRANSFER => true,
    );
    /**
     * Custom options setted by user
     *
     * @var array
     */
    private $custom = array();
    /**
     * Data to send
     *
     * @var array
     */
    private $data = array();
    /**
     * Method for sending data
     *
     * @var integer
     */
    private $method;
    /**
     * Contains last request status code
     *
     * @var integer
     */
    private $lastStatusCode;

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setMethod($method = self::METHOD_DEFAULT)
    {
        switch($method) {
            case self::METHOD_DELETE:
            case self::METHOD_GET:
            case self::METHOD_HEAD:
            case self::METHOD_POST:
            case self::METHOD_PUT:
                $this->method = $method;
                break;
            default:
                throw new Exception('Incorrect method, please you one constant from methods scope');
        }

        return $this;
    }

    public function isMethod($method)
    {
        return (boolean) ($this->method & $method);
    }

    /**
     * Returns response data from remote server
     *
     * @return mixed
     * @throws Exception
     */
    public function getResponse()
    {
        if (empty($this->url)) {
            throw new Exception('URL isn\'t setted');
        }

        $this->_open();
        $this->_build();

        if (($response = curl_exec($this->handle)) === false) {
            $this->lastStatusCode = null;
            throw new Exception(curl_error($this->handle));
        }

        $this->lastStatusCode = (integer) curl_getinfo($this->handle, CURLINFO_HTTP_CODE);

        $this->_close();

        return $response;
    }

    /**
     *
     * @return type
     */
    public function getLastStatusCode()
    {
        return $this->lastStatusCode;
    }

    /**
     * Custom cURL option setter
     *
     * @param integer $option Option num
     * @param mixed $value Option value
     *
     * @return \Box\Transport\Curl
     */
    public function setOption($option, $value)
    {
        $this->custom[$option] = $value;

        return $this;
    }

    public function resetOptions()
    {
        $this->custom = array();

        return $this;
    }

    public function addData($value, $key = null)
    {
        if ($key !== null && !is_scalar($key)) {
            trigger_error('Data key should be a scalar type variable', E_USER_ERROR);
        }

        if (!empty($key)) {
            $this->data[$key] = $value;
        } elseif (strpos($value, '=')) {
            list($key, $value) = explode('=', $value, 2);
            $this->data[$key] = $value;
        } else {
            $this->data[] = $key;
        }

        return $this;
    }

    public function removeData($key)
    {
        if (!empty($key) && is_string($key)) {
            unset($this->data[$key]);
        }

        return $this;
    }

    public function clearData()
    {
        $this->data = array();
    }

    public function reset()
    {
        $this->url = null;
        $this->clearData();
        $this->setGet();
    }

    private function _prepareMethod()
    {
        $this->_resetMethod();

        switch ($this->method) {
            case self::METHOD_DELETE:
                $this->options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                break;
            case self::METHOD_GET:
                $this->options[CURLOPT_HTTPGET] = true;
                break;
            case self::METHOD_HEAD:
                $this->options[CURLOPT_NOBODY] = true;
                break;
            case self::METHOD_POST:
                $this->options[CURLOPT_POST] = true;
                break;
            case self::METHOD_PUT:
                $this->options[CURLOPT_PUT] = true;
                break;
            default:
                $this->method = self::METHOD_DEFAULT;
                return $this->_prepareMethod();
        }
    }

    private function _prepareData()
    {
        if (empty($this->data)) {
            return;
        }

        if ($this->isMethod(self::METHOD_GET) || $this->isMethod(self::METHOD_HEAD)) {
            if (!strpos($this->url, '?')) {
                $this->url .= '?';
            } else {
                $this->url .= '&';
            }

            $this->url .= $this->_dataString();
        } else {
            $this->options[CURLOPT_POSTFIELDS] = $this->_dataString();
        }
    }

    /**
     * Pack data array to key-value string
     *
     * @return string
     */
    private function _dataString()
    {
        $string = '';

        foreach ($this->data as $field => $value) {
            if (is_int($field)) {
                $string .= $value.'&';
            } else {
                $string .= sprintf('%s=%s&', $field, urldecode($value));
            }
        }

        return rtrim($string, '&');
    }

    private function _build()
    {
        $this->_open();
        $this->_prepareMethod();
        $this->_prepareData();

        $options = array_merge($this->options, $this->custom);
        foreach($options as $option => $value) {
            curl_setopt($this->handle, $option, $value);
        }
    }

    private function _open()
    {
        if ($this->handle === null) {
            $this->handle = curl_init();
        }
    }

    private function _close()
    {
        if ($this->handle !== null) {
            curl_close($this->handle);
            $this->handle = null;
        }
    }

    private function _resetMethod()
    {
        unset($this->options[CURLOPT_POST]);
        unset($this->options[CURLOPT_PUT]);
        unset($this->options[CURLOPT_HTTPGET]);
        unset($this->options[CURLOPT_CUSTOMREQUEST]);
        unset($this->options[CURLOPT_NOBODY]);
    }
}
