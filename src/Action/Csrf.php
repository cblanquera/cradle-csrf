<?php //-->
/**
 * This file is part of the Cradle PHP Library.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Framework\Csrf\Action;

use Cradle\Http\Request;
use Cradle\Http\Response;
use Cradle\Framework\App;

/**
 * Typical model create action steps
 *
 * @vendor   Cradle
 * @package  Framework
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class Csrf
{
    /**
     * @const ATTACK Error template
     */
    const ATTACK = 'We prevented a potential attack on our servers coming from the request you just sent us.';

    /**
     * @var string $no
     */
    public $no = 'csrf-406';

    /**
     * @var string $yes
     */
    public $yes = 'csrf-202';

    /**
     * @var App $app
     */
    protected $app = null;

    /**
     * Preps the Action binding the model given
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * check for valid
     *
     * @param *Request  $request
     * @param *Response $response
     *
     * @return Csrf
     */
    public function check(Request $request, Response $response) {
        $actual = $request->getStage('csrf');
        $expected = $request->getSession('csrf');

        if($actual !== $expected) {
            //prepare to error
            $message = $this->app->package('global')->translate(static::ATTACK);
            $response->setError(true, $message);

            //and trigger a subflow
            $this->app->subflow($this->no, $request, $response);
            return $this;
        }

        //it passed
        $this->app->subflow($this->yes, $request, $response);
        return $this;
    }

    /**
     * Loads a token to the request and response
     *
     * @param *Request  $request
     * @param *Response $response
     *
     * @return Csrf
     */
    public function load(Request $request, Response $response) {
        //render the key
        $key = md5(uniqid());

        $request->setSession('csrf', $key);
        $response->setResults('csrf', $key);

        //this does csrf via SESSIONS
        if(isset($_SESSION)) {
            $_SESSION['csrf'] = $key;
        }

        return $this;
    }

    /**
     * Renders a csrf field
     *
     * @param *Request  $request
     * @param *Response $response
     *
     * @return Csrf
     */
    public function render(Request $request, Response $response) {
        $key = $response->getResults('csrf');

        $content = $response->getContent();
        $content .= '<input type="hidden" name="csrf" value="' . $key . '" />';
        $response->setContent($content);

        return $this;
    }
}
