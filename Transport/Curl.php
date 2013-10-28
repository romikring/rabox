<?php
/**
 * Description of Curl
 *
 * @author Roman Habrusionok <romikring@gmail.com>
 */
namespace Box\Transport;

class Curl
{
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

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setPost()
    {
        $this->_purgeSendMethods();
        $this->options[CURLOPT_POST] = true;

        return $this;
    }

    public function setGet()
    {
        $this->_purgeSendMethods();
        $this->options[CURLOPT_HTTPGET] = true;

        return $this;
    }

    public function setDelete()
    {
        $this->_purgeSendMethods();
        $this->options[CURLOPT_CUSTOMREQUEST] = 'DELETE';

        return $this;
    }

    public function setPut()
    {
        $this->_purgeSendMethods();
        $this->options[CURLOPT_PUT] = true;

        return $this;
    }

    public function getResponse()
    {
        if (empty($this->url)) {
            throw new Exception('URL isn\'t setted');
        }

        $this->_open();
        $this->_build();

        if (($response = curl_exec($this->handle)) === false) {
            throw new Exception(curl_error($this->handle));
        }

        $this->_close();

        return $response;
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

    private function _build()
    {
        $this->_open();

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

    private function _purgeSendMethods()
    {
        unset($this->options[CURLOPT_POST]);
        unset($this->options[CURLOPT_PUT]);
        unset($this->options[CURLOPT_HTTPGET]);
        unset($this->options[CURLOPT_CUSTOMREQUEST]);
    }
}
