<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Session\Session;
use Config\Services;

class Account extends BaseController
{
    /**
     * @var Session
     */
    protected $session;

    function __construct()
    {
        $this->session = Services::session();
        $this->session->start();
    }

    /**
     * @return RedirectResponse|string
     */
    public function index()
    {
        if (null !== $this->session->get('userId')) {
            return redirect('home');
        } else {
            $recaptcha = config('Recaptcha');
            return view('register', ['siteKey' => $recaptcha->siteKey]);
        }
    }

    /**
     * @return RedirectResponse|string
     */
    public function home()
    {
        if (null === $this->session->get('userId')) {
            return redirect('/');
        }

        $userModel = new UserModel();
        $users = $userModel->findAll();
        return view('home', ['users' => $users]);
    }


    /**
     * @return Response
     */
    public function register(): Response
    {
        $recaptcha = config('Recaptcha');

        $response = [
            'error' => true,
            'errorMessage' => ''
        ];

        if ($this->request->isAJAX()) {
            $request = $this->request->getPost();
            $email = $request['email'];
            $username = $request['username'];
            $gRecaptchaResponse = $request['gRecaptchaResponse'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['errorMessage'] = "Email $email is not valid";
            } else {
                $userModel = new UserModel();
                $user = $userModel->where('email', $email)->first();

                if (null !== $user) {
                    $response['errorMessage'] = "Email $email already exists";
                } else {
                    $google_url = $recaptcha->siteUrl;
                    $url = $google_url . "?secret=" . $recaptcha->secretKey . "&response=" . $gRecaptchaResponse;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    $status = json_decode($output, true);
                    if ($status['success'] === false || ($status['success'] && $status['score'] <= 0.5)) {
                        $response['errorMessage'] = "Recaptcha not validated";
                    } else {
                        $data = [
                            'username' => $username,
                            'email' => $email
                        ];

                        try {
                            $userModel->save($data);

                            $response = [
                                'error' => false,
                                'userId' => $userModel->getInsertID()
                            ];

                            $this->session->set('userId', $userModel->getInsertID());
                        } catch (\ReflectionException $e) {
                            $response = [
                                'error' => true,
                                'errorMessage' => $e->getMessage()
                            ];
                        }
                    }
                }
            }
        }

        return $this->response->setJSON($response);
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        $this->session->destroy();
        return redirect('/');
    }
}
