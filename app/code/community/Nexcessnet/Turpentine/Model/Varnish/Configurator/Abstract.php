<?php
/**
* Nexcess.net Turpentine Extension for Magento
* Copyright (C) 2012  Nexcess.net L.L.C.
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along
* with this program; if not, write to the Free Software Foundation, Inc.,
* 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

abstract class Nexcessnet_Turpentine_Model_Varnish_Configurator_Abstract
{

    const VCL_CUSTOM_C_CODE_FILE = 'uuid.c';

    /**
     * Path for normalization/encoding
     */
    const CONFIG_EXTENSION_NORMALIZATION_ENCODING = 'turpentine_vcl/normalization/encoding';

    /**
     * Path for normalization/user_agent
     */
    const CONFIG_EXTENSION_NORMALIZATION_USERAGENT = 'turpentine_vcl/normalization/user_agent';

    /**
     * Path for normalization/host
     */
    const CONFIG_EXTENSION_NORMALIZATION_HOST = 'turpentine_vcl/normalization/host';

    /**
     * Path for normalization/host_target
     */
    const CONFIG_EXTENSION_NORMALIZATION_HOSTTARGET = 'turpentine_vcl/normalization/host_target';

    /**
     * Path for servers/config_file
     */
    const CONFIG_EXTENSION_SERVERS_CONFIGFILE = 'turpentine_varnish/servers/config_file';

    /**
     * Path for servers/custom_include_file
     */
    const CONFIG_EXTENSION_SERVERS_CUSTOMINCLUDEFILE = 'turpentine_varnish/servers/custom_include_file';

    /**
     * Path for session/use_http_user_agent
     */
    const CONFIG_EXTENSION_SESSION_USEHTTPUSERAGENT = 'web/session/use_http_user_agent';

    /**
     * Path for session/use_remote_addr
     */
    const CONFIG_EXTENSION_SESSION_USEREMOTEADDR = 'web/session/use_remote_addr';

    /**
     * Path for session/use_http_via
     */
    const CONFIG_EXTENSION_SESSION_USEHTTPVIA = 'web/session/use_http_via';

    /**
     * Path for session/use_http_x_forwarded_for
     */
    const CONFIG_EXTENSION_SESSION_USEHTTPXFORWARDEDFOR = 'web/session/use_http_x_forwarded_for';

    /**
     * Path for backend/frontend_timeout
     */
    const CONFIG_EXTENSION_BACKEND_FRONTENDTIMEOUT = 'turpentine_vcl/backend/frontend_timeout';

    /**
     * Path for backend/frontend_timeout
     */
    const CONFIG_EXTENSION_BACKEND_ADMINTIMEOUT = 'turpentine_vcl/backend/admin_timeout';

    /**
     * Path for backend/backend_host
     */
    const CONFIG_EXTENSION_BACKEND_BACKENDHOST = 'turpentine_vcl/backend/backend_host';

    /**
     * Path for backend/backend_port
     */
    const CONFIG_EXTENSION_BACKEND_BACKENDPORT = 'turpentine_vcl/backend/backend_port';

    /**
     * Path for backend/crawler_user_agents
     */
    const CONFIG_EXTENSION_BACKEND_CRAWLERUSERAGENTS = 'turpentine_vcl/backend/crawler_user_agents';

    /**
     * Path for backend/crawlers
     */
    const CONFIG_EXTENSION_BACKEND_CRAWLERS = 'turpentine_vcl/backend/crawlers';

    /**
     * Path for general/varnish_debug
     */
    const CONFIG_EXTENSION_GENERAL_VARNISHDEBUG = 'turpentine_vcl/general/varnish_debug';

    /**
     * Path for url/use_custom_path
     */
    const CONFIG_EXTENSION_URL_USECUSTOMPATH = 'admin/url/use_custom_path';

    /**
     * Path for url/use_custom_path
     */
    const CONFIG_EXTENSION_PARAMS_GETPARAMS = 'turpentine_vcl/params/get_params';

    /**
     * Path for static/force_static
     */
    const CONFIG_EXTENSION_STATIC_FORCESTATIC = 'turpentine_vcl/static/force_static';

    /**
     * Path for static/exts
     */
    const CONFIG_EXTENSION_STATIC_EXTS = 'turpentine_vcl/static/exts';

    /**
     * Path for urls/url_blacklist
     */
    const CONFIG_EXTENSION_URLS_URLBLACKLIST = 'turpentine_vcl/urls/url_blacklist';

    /**
     * Path for ttls/grace_period
     */
    const CONFIG_EXTENSION_TTLS_GRACEPERIOD = 'turpentine_vcl/ttls/grace_period';

    /**
     * Path for ttls/static_ttl
     */
    const CONFIG_EXTENSION_TTLS_STATICTTL = 'turpentine_vcl/ttls/static_ttl';

    /**
     * Path for ttls/static_ttl
     */
    const CONFIG_EXTENSION_TTLS_URLTTLS = 'turpentine_vcl/ttls/url_ttls';

    /**
     * Path for ttls/lru_factor
     */
    const CONFIG_EXTENSION_TTLS_LRUFACTOR = 'turpentine_vcl/ttls/lru_factor';

    /**
     * Path for ttls/static_ttl
     */
    const CONFIG_EXTENSION_RESTRICT_ALLOWIPS = 'dev/restrict/allow_ips';

    /**
     * Variable for whether Turpentine should normalize the encoding
     *
     * @var bool
     */
    protected $bNormalizeEncoding;

    /**
     * Variable for whether Turpentine should normalize the user_agent
     *
     * @var bool
     */
    protected $bNormalizeUserAgent;

    /**
     * Variable for whether Turpentine should normalize the host
     *
     * @var bool
     */
    protected $bNormalizeHost;

    /**
     * Variable for whether Turpentine should respect User-Agent Headers
     *
     * @var bool
     */
    protected $bUseHttpUserAgent;

    /**
     * Variable for whether Turpentine should use the remote Address
     *
     * @var bool
     */
    protected $bUseRemoteAddr;

    /**
     * Variable for whether Turpentine should respect User-Agent Headers
     *
     * @var bool
     */
    protected $bUseHttpVia;

    /**
     * Variable for whether Turpentine should respect X-Forwarded-For Headers
     *
     * @var bool
     */
    protected $bUseHttpXForwardedFor;

    /**
     * Variable for whether Magento uses a custom admin path
     *
     * @var bool
     */
    protected $bUseCustomPath;

    /**
     * Variable for whether Turpentine should force static
     *
     * @var bool
     */
    protected $bForceStatic;

    /**
     * Variable for Varnish Servers Configfile
     *
     * @var string
     */
    protected $sServersConfigFile;

    /**
     * Variable for Varnish custom include file
     *
     * @var string
     */
    protected $sCustomIncludeFile;

    /**
     * Variable for Varnish frontend timeout
     *
     * @var string
     */
    protected $sFrontendTimeout;

    /**
     * Variable for Varnish admin timeout
     *
     * @var string
     */
    protected $sAdminTimeout;

    /**
     * Variable for Varnish backend host
     *
     * @var string
     */
    protected $sBackendHost;

    /**
     * Variable for Varnish backend port
     *
     * @var string
     */
    protected $sBackendPort;

    /**
     * Variable for Varnish debugging
     *
     * @var string
     */
    protected $sVarnishDebug;

    /**
     * Variable for Magento custom admin path
     *
     * @var string
     */
    protected $sCustomPath;

    /**
     * Variable for hostname for host normalization from Magento's base URL
     *
     * @var string
     */
    protected $sHostTarget;

    /**
     * Variable for GET parameters
     *
     * @var string
     */
    protected $sGetParams;

    /**
     * Variable for static file extensions
     *
     * @var string
     */
    protected $sStaticExts;

    /**
     * Variable for URL blacklist
     *
     * @var string
     */
    protected $sUrlBlacklist;

    /**
     * Variable for grace period
     *
     * @var string
     */
    protected $sGracePeriod;

    /**
     * Variable for static ttl
     *
     * @var string
     */
    protected $sStaticTtl;

    /**
     * Variable for url ttls
     *
     * @var string
     */
    protected $sUrlTtls;

    /**
     * Variable for crawler user agents
     *
     * @var string
     */
    protected $sCrawlerUserAgents;

    /**
     * Variable for crawlers
     *
     * @var string
     */
    protected $sCrawlers;

    /**
     * Variable for allowed dev IPs
     *
     * @var string
     */
    protected $sAllowIps;

    /**
     * Variable for LRU factor
     *
     * @var string
     */
    protected $sLruFactor;

    /**
    * Get the correct version of a configurator from a socket
    *
    * @param  Nexcessnet_Turpentine_Model_Varnish_Admin_Socket $socket
    * @return Nexcessnet_Turpentine_Model_Varnish_Configurator_Abstract
    */
    static public function getFromSocket($socket)
    {
        try
        {
            $version = $socket->getVersion();
        }
        catch(Mage_Core_Exception $e)
        {
            Mage::getSingleton('core/session')->addError('Error determining Varnish version: ' . $e->getMessage());
            return null;
        }
        switch($version)
        {
            case '4.0':
            return Mage::getModel('turpentine/varnish_configurator_version4', array('socket' => $socket));
            case '3.0':
            return Mage::getModel('turpentine/varnish_configurator_version3', array('socket' => $socket));
            case '2.1':
            return Mage::getModel('turpentine/varnish_configurator_version2', array('socket' => $socket));
            default:
            Mage::throwException('Unsupported Varnish version');
        }
    }

    /**
    * The socket this configurator is based on
    *
    * @var Nexcessnet_Turpentine_Model_Varnish_Admin_Socket
    */
    protected $_socket = null;

    /**
    * options array
    *
    * @var array
    */
    protected $_options = array('vcl_template' => null);

    public function __construct($options=array())
    {
        $this->_options = array_merge($this->_options, $options);
    }

    abstract public function generate($doClean = true);
    // abstract protected function _getTemplateVars();

    /**
    * Save the generated config to the file specified in Magento config
    *
    * @param  string $generatedConfig config generated by @generate
    * @return null
    */
    public function save($generatedConfig)
    {
        $filename = $this->_getVclFilename();
        $dir = dirname($filename);
        if (!is_dir($dir))
        {
            // this umask is probably redundant, but just in case...
            if (!mkdir($dir, 0777 & ~umask(), true))
            {
                $err = error_get_last();
                return array(false, $err);
            }
        }
        if (strlen($generatedConfig) !== file_put_contents($filename, $generatedConfig))
        {
            $err = error_get_last();
            return array(false, $err);
        }
        return array(true, null);
    }

    /**
    * Get the full path for a given template filename
    *
    * @param  string $baseFilename
    * @return string
    */
    protected function _getVclTemplateFilename($baseFilename)
    {
        $extensionDir = Mage::getModuleDir('', 'Nexcessnet_Turpentine');
        return sprintf('%s/misc/%s', $extensionDir, $baseFilename);
    }

    /**
    * Get the name of the file to save the VCL to
    *
    * @return string
    */
    protected function _getVclFilename()
    {
        return $this->_formatTemplate($this->getStoreConfig(self::CONFIG_EXTENSION_SERVERS_CONFIGFILE, 'sServersConfigFile'), array('root_dir' => Mage::getBaseDir()));
    }

    /**
    * Get the name of the custom include VCL file
    *
    * @return string
    */
    protected function _getCustomIncludeFilename()
    {
        return $this->_formatTemplate($this->getStoreConfig(self::CONFIG_EXTENSION_SERVERS_CUSTOMINCLUDEFILE, 'sCustomIncludeFile'), array('root_dir' => Mage::getBaseDir()));
    }

    /**
    * Format a template string, replacing {{keys}} with the appropriate values
    * and remove unspecified keys
    *
    * @param  string $template template string to operate on
    * @param  array  $vars     array of key => value replacements
    * @return string
    */
    protected function _formatTemplate($template, array $vars)
    {
        $needles = array_map(create_function('$k', 'return "{{".$k."}}";'), array_keys($vars));
        $replacements = array_values($vars);
        // do replacements, then delete unused template vars
        return preg_replace('~{{[^}]+}}~', '', str_replace($needles, $replacements, $template));
    }

    /**
    * Format a VCL subroutine call
    *
    * @param  string $subroutine subroutine name
    * @return string
    */
    protected function _vcl_call($subroutine)
    {
        return sprintf('call %s;', $subroutine);
    }

    /**
    * Get the Magento admin frontname
    *
    * This is just the plain string, not in URL format. ex:
    * http://example.com/magento/admin -> admin
    *
    * @return string
    */
    protected function _getAdminFrontname()
    {
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_URL_USECUSTOMPATH, 'bUseCustomPath'))
        {
            return $this->getStoreConfig(self::CONFIG_EXTENSION_URL_CUSTOMPATH, 'sCustomPath'));
        }
        else
        {
            return (string)Mage::getConfig()->getNode('admin/routers/adminhtml/args/frontName');
        }
    }

    /**
    * Get the hostname for host normalization from Magento's base URL
    *
    * @return string
    */
    protected function _getNormalizeHostTarget()
    {
        $configHost = trim($this->getStoreConfig(self::CONFIG_EXTENSION_NORMALIZATION_HOSTTARGET, 'sHostTarget'));
        if ($configHost)
        {
            return $configHost;
        }
        else
        {
            $baseUrl = parse_url(Mage::getBaseUrl());
            if (isset($baseUrl['port']))
            {
                return sprintf('%s:%d', $baseUrl['host'], $baseUrl['port']);
            }
            else
            {
                return $baseUrl['host'];
            }
        }
    }

    /**
    * Get the base url path regex
    *
    * ex: base_url: http://example.com/magento/
    *     path_regex: /magento/(?:(?:index|litespeed)\.php/)?
    *
    * @return string
    */
    public function getBaseUrlPathRegex()
    {
        $pattern = '^(%s)(?:(?:index|litespeed)\\.php/)?';
        return sprintf($pattern, implode('|', array_map(create_function('$x', 'return preg_quote($x,"|");'), $this->_getBaseUrlPaths())));
    }

    /**
    * Get the path part of each store's base URL and static file URLs
    *
    * @return array
    */
    protected function _getBaseUrlPaths()
    {
        $paths = array();
        $linkTypes = array(Mage_Core_Model_Store::URL_TYPE_LINK,
        Mage_Core_Model_Store::URL_TYPE_JS,
        Mage_Core_Model_Store::URL_TYPE_SKIN,
        Mage_Core_Model_Store::URL_TYPE_MEDIA);
        foreach (Mage::app()->getStores() as $store)
        {
            foreach ($linkTypes as $linkType)
            {
                $paths[] = parse_url($store->getBaseUrl($linkType , false), PHP_URL_PATH);
                $paths[] = parse_url($store->getBaseUrl($linkType , true), PHP_URL_PATH);
            }
        }
        $paths = array_unique($paths);
        usort($paths, create_function('$a, $b', 'return strlen($b) - strlen($a);'));
        return array_values($paths);
    }

    /**
    * Format the URL exclusions for insertion in a regex. Admin frontname and
    * API are automatically added.
    *
    * @return string
    */
    protected function _getUrlExcludes()
    {
        $urls = $this->getStoreConfig(self::CONFIG_EXTENSION_URLS_URLBLACKLIST, 'sUrlBlacklist');
        return implode('|', array_merge(array($this->_getAdminFrontname(), 'api'), Mage::helper('turpentine/data')->cleanExplode(PHP_EOL, $urls)));
    }

    /**
    * Get the default cache TTL from Magento config
    *
    * @return string
    */
    protected function _getDefaultTtl()
    {
        return Mage::helper('turpentine/varnish')->getDefaultTtl();
    }

    /**
    * Get the default backend configuration string
    *
    * @return string
    */
    protected function _getDefaultBackend()
    {
        $timeout = $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_FRONTENDTIMEOUT, 'sFrontendTimeout');
        $default_options = array(
            'first_byte_timeout' => $timeout . 's',
            'between_bytes_timeout' => $timeout . 's',
        );
        return $this->_vcl_backend('default',
        $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_BACKENDHOST, 'sBackendHost'),
        $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_BACKENDPORT, 'sBackendPort'),
        $default_options);
    }

    /**
    * Get the admin backend configuration string
    *
    * @return string
    */
    protected function _getAdminBackend()
    {
        $timeout = $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_ADMINTIMEOUT, 'sAdminTimeout');
        $admin_options = array(
            'first_byte_timeout' => $timeout . 's',
            'between_bytes_timeout' => $timeout . 's',
        );
        return $this->_vcl_backend('admin',
        $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_BACKENDHOST, 'sBackendHost'),
        $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_BACKENDPORT, 'sBackendPort'),
        $admin_options);
    }

    /**
    * Get the grace period for vcl_fetch
    *
    * This is curently hardcoded to 15 seconds, will be configurable at some
    * point
    *
    * @return string
    */
    protected function _getGracePeriod()
    {
        return $this->getStoreConfig(self::CONFIG_EXTENSION_TTLS_GRACEPERIOD, 'sGracePeriod');
    }

    /**
    * Get whether debug headers should be enabled or not
    *
    * @return string
    */
    protected function _getEnableDebugHeaders()
    {
        return $this->getStoreConfig(self::CONFIG_EXTENSION_GENERAL_VARNISHDEBUG, 'sVarnishDebug') ? 'true' : 'false';
    }

    /**
    * Format the GET variable excludes for insertion in a regex
    *
    * @return string
    */
    protected function _getGetParamExcludes()
    {
        return implode('|', Mage::helper('turpentine/data')->cleanExplode(',', $this->getStoreConfig(self::CONFIG_EXTENSION_PARAMS_GETPARAMS, 'sGetParams')));
    }

    /**
    * Get the Force Static Caching option
    *
    * @return string
    */
    protected function _getForceCacheStatic()
    {
        return $this->getStoreFlag(self::CONFIG_EXTENSION_STATIC_FORCESTATIC, 'bForceStatic') ? 'true' : 'false';
    }

    /**
    * Format the list of static cache extensions
    *
    * @return string
    */
    protected function _getStaticExtensions()
    {
        return implode('|', Mage::helper('turpentine/data')->cleanExplode(',', $this->getStoreConfig(self::CONFIG_EXTENSION_STATIC_EXTS, 'sStaticExts')));
    }

    /**
    * Get the static caching TTL
    *
    * @return string
    */
    protected function _getStaticTtl() {
        return $this->getStoreConfig(self::CONFIG_EXTENSION_TTLS_STATICTTL, 'sStaticTtl');
    }

    /**
    * Format the by-url TTL value list
    *
    * @return string
    */
    protected function _getUrlTtls()
    {
        $str = array();
        $configTtls = Mage::helper('turpentine/data')->cleanExplode(PHP_EOL, $this->getStoreConfig(self::CONFIG_EXTENSION_TTLS_URLTTLS, 'sUrlTtls'));
        $ttls = array();
        foreach ($configTtls as $line)
        {
            $ttls[] = explode(',', trim($line));
        }
        foreach ($ttls as $ttl)
        {
            $str[] = sprintf('if (bereq.url ~ "%s%s") { set beresp.ttl = %ds; }', $this->getBaseUrlPathRegex(), $ttl[0], $ttl[1]);
        }
        $str = implode(' else ', $str);
        if ($str)
        {
            $str .= sprintf(' else { set beresp.ttl = %ds; }', $this->_getDefaultTtl());
        }
        else
        {
            $str = sprintf('set beresp.ttl = %ds;', $this->_getDefaultTtl());
        }
        return $str;
    }

    /**
    * Get the Enable Caching value
    *
    * @return string
    */
    protected function _getEnableCaching()
    {
        return Mage::helper('turpentine/varnish')->getVarnishEnabled() ? 'true' : 'false';
    }

    /**
    * Get the list of allowed debug IPs
    *
    * @return array
    */
    protected function _getDebugIps()
    {
        return Mage::helper('turpentine/data')->cleanExplode(',', $this->getStoreConfig(self::CONFIG_EXTENSION_RESTRICT_ALLOWIPS, 'sAllowIps'));
    }

    /**
    * Get the list of crawler IPs
    *
    * @return array
    */
    protected function _getCrawlerIps()
    {
        return Mage::helper('turpentine/data')->cleanExplode(',', $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_CRAWLERS, 'sCrawlers'));
    }

    /**
    * Get the regex formatted list of crawler user agents
    *
    * @return string
    */
    protected function _getCrawlerUserAgents()
    {
        return implode('|', Mage::helper('turpentine/data')->cleanExplode(',', $this->getStoreConfig(self::CONFIG_EXTENSION_BACKEND_CRAWLERUSERAGENTS, 'sCrawlerUserAgents')));
    }

    /**
    * Get the time to increase a cached objects TTL on cache hit (in seconds).
    *
    * This should be set very low since it gets added to every hit.
    *
    * @return string
    */
    protected function _getLruFactor()
    {
        return $this->getStoreConfig(self::CONFIG_EXTENSION_TTLS_LRUFACTOR, 'sLruFactor');
    }

    /**
    * Get the advanced session validation restrictions
    *
    * Note that if User-Agent Normalization is on then the normalized user-agent
    * is used for user-agent validation instead of the full user-agent
    *
    * @return string
    */
    protected function _getAdvancedSessionValidationTargets()
    {
        $validation = array();
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_SESSION_USEREMOTEADDR, 'bUseRemoteAddr'))
        {
            $validation[] = 'client.ip';
        }
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_SESSION_USEHTTPVIA, 'bUseHttpVia'))
        {
            $validation[] = 'req.http.Via';
        }
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_SESSION_USEHTTPXFORWARDEDFOR, 'bUseHttpXForwardedFor'))
        {
            $validation[] = 'req.http.X-Forwarded-For';
        }
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_SESSION_USEHTTPUSERAGENT, 'bUseHttpUserAgent') && !$this->getStoreFlag(self::CONFIG_EXTENSION_NORMALIZATION_USERAGENT, 'bNormalizeUserAgent'))
        {
            $validation[] = 'req.http.User-Agent';
        }
        return $validation;
    }

    /**
    * Remove empty and commented out lines from the generated VCL
    *
    * @param  string $dirtyVcl generated vcl
    * @return string
    */
    protected function _cleanVcl($dirtyVcl)
    {
        return implode(PHP_EOL, array_filter(Mage::helper('turpentine/data')->cleanExplode(PHP_EOL, $dirtyVcl), array($this, '_cleanVclHelper')));
    }

    /**
    * Helper to filter out blank/commented lines for VCL cleaning
    *
    * @param  string $line
    * @return bool
    */
    protected function _cleanVclHelper($line)
    {
        return $line && ((substr($line, 0, 1) != '#' && substr($line, 0, 2) != '//') || substr($line, 0, 8) == '#include');
    }

    /**
    * Format a VCL backend declaration
    *
    * @param  string $name    name of the backend
    * @param  string $host    backend host
    * @param  string $port    backend port
    * @param  array  $options options
    * @return string
    */
    protected function _vcl_backend($name, $host, $port, $options = array())
    {
        $tpl = <<<EOS
backend {{name}} {
    .host = "{{host}}";
    .port = "{{port}}";
EOS;
        $vars = array(
            'host' => $host,
            'port' => $port,
            'name' => $name,
       );
        $str = $this->_formatTemplate($tpl, $vars);
        foreach ($options as $key => $value)
        {
            $str .= sprintf('   .%s = %s;', $key, $value) . PHP_EOL;
        }
        $str .= '}' . PHP_EOL;
        return $str;
    }

    /**
    * Format a VCL ACL declaration
    *
    * @param  string $name  ACL name
    * @param  array  $hosts list of hosts to add to the ACL
    * @return string
    */
    protected function _vcl_acl($name, array $hosts)
    {
        $tpl = <<<EOS
acl {{name}} {
    {{hosts}}
}
EOS;
        $fmtHost = create_function('$h', 'return sprintf(\'"%s";\',$h);');
        $vars = array(
            'name'  => $name,
            'hosts' => implode("\n    ", array_map($fmtHost, $hosts)),
       );
        return $this->_formatTemplate($tpl, $vars);
    }

    /**
    * Get the User-Agent normalization sub routine
    *
    * @return string
    */
    protected function _vcl_sub_normalize_user_agent()
    {
        /**
        * Mobile regex from
        * @link http://magebase.com/magento-tutorials/magento-design-exceptions-explained/
        */
        $tpl = <<<EOS
    if (
         req.http.User-Agent ~ "(?i)ip(hone|od)" ||
         req.http.User-Agent ~ "(?i)android.*(mobile|mini)" ||
         req.http.User-Agent ~ "Opera Mobi" ||
         req.http.User-Agent ~ "Fennec" ||
         req.http.User-Agent ~ "IEMobile" ||
         req.http.User-Agent ~ "BlackBerry" ||
         req.http.User-Agent ~ "BB10.*Mobile" ||
         req.http.User-Agent ~ "GT-.*Build/GINGERBREAD" ||
         req.http.User-Agent ~ "SymbianOS.*AppleWebKit" ||
         req.http.User-Agent ~ "Mobile.+Firefox" ||
         req.http.User-Agent ~ "(?i)symbian" ||
         req.http.User-Agent ~ "(?i)^sonyericsson" ||
         req.http.User-Agent ~ "(?i)^nokia" ||
         req.http.User-Agent ~ "(?i)^samsung" ||
         req.http.User-Agent ~ "(?i)^lg" ||
         req.http.User-Agent ~ "(?i)bada" ||
         req.http.User-Agent ~ "(?i)blazer" ||
         req.http.User-Agent ~ "(?i)cellphone" ||
         req.http.User-Agent ~ "(?i)iemobile" ||
         req.http.User-Agent ~ "(?i)midp-2.0" ||
         req.http.User-Agent ~ "(?i)u990" ||
         req.http.User-Agent ~ "(?i)netfront" ||
         req.http.User-Agent ~ "(?i)opera mini" ||
         req.http.User-Agent ~ "(?i)palm" ||
         req.http.User-Agent ~ "(?i)nintendo wii" ||
         req.http.User-Agent ~ "(?i)playstation portable" ||
         req.http.User-Agent ~ "(?i)portalmmm" ||
         req.http.User-Agent ~ "(?i)proxinet" ||
         req.http.User-Agent ~ "(?i)sonyericsson" ||
         req.http.User-Agent ~ "(?i)symbian" ||
         req.http.User-Agent ~ "(?i)windows\ ?ce" ||
         req.http.User-Agent ~ "(?i)winwap" ||
         req.http.User-Agent ~ "(?i)eudoraweb" ||
         req.http.User-Agent ~ "(?i)htc" ||
         req.http.User-Agent ~ "(?i)240x320" ||
         req.http.User-Agent ~ "(?i)avantgo") {
         set req.http.X-Normalized-User-Agent = "mobile";
    } else if (req.http.User-Agent ~ "MSIE") {
        set req.http.X-Normalized-User-Agent = "msie";
    } else if (req.http.User-Agent ~ "Firefox") {
        set req.http.X-Normalized-User-Agent = "firefox";
    } else if (req.http.User-Agent ~ "Chrome") {
        set req.http.X-Normalized-User-Agent = "chrome";
    } else if (req.http.User-Agent ~ "Safari") {
        set req.http.X-Normalized-User-Agent = "safari";
    } else if (req.http.User-Agent ~ "Opera") {
        set req.http.X-Normalized-User-Agent = "opera";
    }
else
{
        set req.http.X-Normalized-User-Agent = "other";
    }

EOS;
        return $tpl;
    }

    /**
    * Get the Accept-Encoding normalization sub routine
    *
    * @return string
    */
    protected function _vcl_sub_normalize_encoding()
    {
        $tpl = <<<EOS
if (req.http.Accept-Encoding) {
        if (req.http.Accept-Encoding ~ "gzip") {
            set req.http.Accept-Encoding = "gzip";
        } else if (req.http.Accept-Encoding ~ "deflate") {
            set req.http.Accept-Encoding = "deflate";
        }
else
{
            # unknown algorithm
            unset req.http.Accept-Encoding;
        }
    }

EOS;
        return $tpl;
    }

    /**
    * Get the Host normalization sub routine
    *
    * @return string
    */
    protected function _vcl_sub_normalize_host()
    {
        $tpl = <<<EOS
set req.http.Host = "{{normalize_host_target}}";

EOS;
        return $this->_formatTemplate($tpl, array('normalize_host_target' => $this->_getNormalizeHostTarget()));
    }

    /**
    * Build the list of template variables to apply to the VCL template
    *
    * @return array
    */
    protected function _getTemplateVars()
    {
        $vars = array(
            'default_backend' => $this->_getDefaultBackend(),
            'admin_backend' => $this->_getAdminBackend(),
            'admin_frontname' => $this->_getAdminFrontname(),
            'normalize_host_target' => $this->_getNormalizeHostTarget(),
            'url_base_regex' => $this->getBaseUrlPathRegex(),
            'url_excludes' => $this->_getUrlExcludes(),
            'get_param_excludes' => $this->_getGetParamExcludes(),
            'default_ttl' => $this->_getDefaultTtl(),
            'enable_get_excludes' => ($this->_getGetParamExcludes() ? 'true' : 'false'),
            'debug_headers' => $this->_getEnableDebugHeaders(),
            'grace_period' => $this->_getGracePeriod(),
            'force_cache_static' => $this->_getForceCacheStatic(),
            'static_extensions' => $this->_getStaticExtensions(),
            'static_ttl' => $this->_getStaticTtl(),
            'url_ttls' => $this->_getUrlTtls(),
            'enable_caching' => $this->_getEnableCaching(),
            'crawler_acl' => $this->_vcl_acl('crawler_acl', $this->_getCrawlerIps()),
            'esi_cache_type_param' => Mage::helper('turpentine/esi')->getEsiCacheTypeParam(),
            'esi_method_param' => Mage::helper('turpentine/esi')->getEsiMethodParam(),
            'esi_ttl_param' => Mage::helper('turpentine/esi')->getEsiTtlParam(),
            'secret_handshake' => Mage::helper('turpentine/varnish')->getSecretHandshake(),
            'crawler_user_agent_regex' => $this->_getCrawlerUserAgents(),
            // 'lru_factor' => $this->_getLruFactor(),
            'debug_acl' => $this->_vcl_acl('debug_acl', $this->_getDebugIps()),
            'custom_c_code' => file_get_contents($this->_getVclTemplateFilename(self::VCL_CUSTOM_C_CODE_FILE)),
            'esi_private_ttl' => Mage::helper('turpentine/esi')->getDefaultEsiTtl(),
        );
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_NORMALIZATION_ENCODING, 'bNormalizeEncoding'))
        {
            $vars['normalize_encoding'] = $this->_vcl_sub_normalize_encoding();
        }
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_NORMALIZATION_USERAGENT, 'bNormalizeUserAgent'))
        {
            $vars['normalize_user_agent'] = $this->_vcl_sub_normalize_user_agent();
        }
        if ($this->getStoreFlag(self::CONFIG_EXTENSION_NORMALIZATION_HOST, 'bNormalizeHost'))
        {
            $vars['normalize_host'] = $this->_vcl_sub_normalize_host();
        }
        $customIncludeFile = $this->_getCustomIncludeFilename();
        if (is_readable($customIncludeFile))
        {
            $vars['custom_vcl_include'] = file_get_contents($customIncludeFile);
        }
        return $vars;
    }
}
