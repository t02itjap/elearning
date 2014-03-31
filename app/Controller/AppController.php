<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $uses = array ('User','Category','ChangeableValue');
	var $helpers = array('Html', 'Form', 'Editor');
    var $components = array( 'RequestHandler',
                                'Acl',
                                'Session',
                                'Auth' => array(
                                                'loginRedirect' => array('controller' => 'users','action' => 'index'),
                                                'logoutRedirect' => array('controller' => 'users','action' => 'login'),
                                                'authenticate' => array(
                                                    "Form" => array(
                                                        'userModel' => 'User',
                                                        "fields" => array(
                                                            'username' => "user_name",
                                                            'password' => "password"),
                                                    	"scope" => array(
                                                    		"approve_flag"=>1,
                                                    		"status_flag"=>1 )
                                                            )
                                                            )
                                                            ));
    
    public function beforeFilter(){
        parent::beforeFilter();
        $this->set("sessiontime",$this->ChangeableValue->field('current_value',array('id'=>1)));
        $this->Auth->allow(array('view_all_lessons', 'lessons_by_category', 'search_result'));
        if (isset($this->params['requested'])) $this->Auth->allow($this->action); 
    }
    public function category(){
    	$categoryList = $this->Category->find('all');
    	if (!empty($this->request->params['requested'])) {
    		return $categoryList;
		}
        
    	$this->set(compact('categoryList'));
    }
    public function acc_info(){
    	$user = $this->User->find('first', array(
    		'conditions' => array('id' => $this->Auth->user('id')),
    	));
    	if (!empty($this->request->params['requested'])) {
    		return $user;
		}
    	$this->set(compact('user'));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
