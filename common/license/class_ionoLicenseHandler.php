<?php
/**
*
*
* @	Author			: By Haking Br
* @	Author			: Por Haking Br
* @ Brasil
* @	Release on		:	03.10.2011
*
*/

class IonoLicenseHandler
{

    public $home_url_site = "";
    public $home_url_port = 80;
    public $home_url_iono = "remote.php";
    public $user_defined_string = "3a08f7d2675c";
    public $comm_terminate = true;
    public $license_terminate = true;
    public $product_license_id = 0;
    public $product_id = 0;

    public function setErrorTexts( $err_text )
    {
        $this->error_text = $err_text;
    }

    public function setCFGAppLicenseValues( $CFG )
    {
        $this->home_url_site = $CFG['app_license']['home_url_site'];
        $this->home_url_port = $CFG['app_license']['home_url_port'];
        $this->home_url_iono = $CFG['app_license']['home_url_iono'];
        $this->user_defined_string = $CFG['app_license']['user_defined_string'];
        $this->product_license_id = $CFG['app_license']['product_license_id'];
        $this->product_id = $CFG['app_license']['product_id'];
    }

    public function ionLicenseHandler( $license_key, $request_type )
    {
        if ( !empty( $this->product_id ) )
        {
            $key_parts = explode( "-", $license_key );
            if ( !isset( $key_parts[2] ) || $key_parts[2] != $this->product_id )
            {
                return $this->error_text['wrong_product'];
            }
        }
        if ( !empty( $this->product_license_id ) )
        {
            $key_parts = explode( "-", $license_key );
            $product_license_id = array(
                substr( md5( $this->product_license_id ), 0, 8 )
            );
            if ( !in_array( $key_parts[4], $product_license_id ) )
            {
                return $this->error_text['wrong_product'];
            }
        }
        $host = $_SERVER['HTTP_HOST'];
        if ( strcasecmp( "www.", substr( $_SERVER['HTTP_HOST'], 0, 4 ) ) == 0 )
        {
            $host = substr( $_SERVER['HTTP_HOST'], 4 );
        }
        $request = "remote=licenses&type=".$request_type."&license_key=".urlencode( base64_encode( $license_key ) );
        $request .= "&host_ip=".urlencode( base64_encode( $_SERVER['SERVER_ADDR'] ) )."&host_name=".urlencode( base64_encode( $host ) );
        $request .= "&hash=".urlencode( base64_encode( md5( $request ) ) );
        $request = $this->home_url_site.$this->home_url_iono."?".$request;
        $ch = curl_init( );
        curl_setopt( $ch, CURLOPT_URL, $request );
        curl_setopt( $ch, CURLOPT_PORT, $this->home_url_port );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_USERAGENT, "iono (www.olate.co.uk/iono)" );
        $content = curl_exec( $ch );
        curl_close( $ch );
        if ( !$content )
        {
            return "Unable to communicate with Iono";
        }
        $content = explode( "-", $content );
        $status = $content[0];
        $hash = $content[1];
        if ( $hash == md5( $this->user_defined_string.$host ) )
        {
            switch ( $status )
            {
            case 0 :
                $err_msg = $this->error_text['disabled'];
                unset( $home_url_site );
                unset( $home_url_iono );
                unset( $user_defined_string );
                unset( $request );
                unset( $header );
                unset( $return );
                unset( $fpointer );
                unset( $content );
                unset( $status );
                unset( $hash );
                break;
            case 1 :
                $err_msg = "";
                break;
            case 2 :
                $err_msg = $this->error_text['suspended'];
                unset( $home_url_site );
                unset( $home_url_iono );
                unset( $user_defined_string );
                unset( $request );
                unset( $header );
                unset( $return );
                unset( $fpointer );
                unset( $content );
                unset( $status );
                unset( $hash );
                break;
            case 3 :
                $err_msg = $this->error_text['expired'];
                unset( $home_url_site );
                unset( $home_url_iono );
                unset( $user_defined_string );
                unset( $request );
                unset( $header );
                unset( $return );
                unset( $fpointer );
                unset( $content );
                unset( $status );
                unset( $hash );
                break;
            case 4 :
                $err_msg = $this->error_text['exceeded'];
                unset( $home_url_site );
                unset( $home_url_iono );
                unset( $user_defined_string );
                unset( $request );
                unset( $header );
                unset( $return );
                unset( $fpointer );
                unset( $content );
                unset( $status );
                unset( $hash );
                break;
            case 10 :
            }
            $err_msg = $this->error_text['invalid_user'];
            unset( $home_url_site );
            unset( $home_url_iono );
            unset( $user_defined_string );
            unset( $request );
            unset( $header );
            unset( $return );
            unset( $fpointer );
            unset( $content );
            unset( $status );
            unset( $hash );
            break;
            $err_msg = $this->error_text['invalid_code'];
            unset( $home_url_site );
            unset( $home_url_iono );
            unset( $user_defined_string );
            unset( $request );
            unset( $header );
            unset( $return );
            unset( $fpointer );
            unset( $content );
            unset( $status );
            unset( $hash );
            break;
            return $err_msg;
        }
        return $this->error_text['invalid_hash'];
    }

}

?>
