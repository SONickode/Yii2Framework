<?php
namespace app\components;

use app\modules\user\models\Auth;
use app\modules\user\models\User;
use app\modules\user\models\LoginForm;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

class AuthHandler
{

    /**
     * @var ClientInterface
     */
    private $client;
    public $authclient;
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->authclient = $_GET['authclient'];
    }

    public function handle()
    {
        if (!Yii::$app->user->isGuest) {
            return;
        }

        $attributes = $this->client->getUserAttributes();        
        $auth = $this->findAuth($attributes);
        
        if ($auth) {
            /* @var User $user */
            $user = $auth->user;
            return Yii::$app->user->login($user);
        }else{
            $user = $this->createAccount($attributes);           
            return Yii::$app->user->login($user);
        }
    }

    /**
     * @param array $attributes
     * @return Auth
     */
    private function findAuth($attributes)
    {
        $id = ArrayHelper::getValue($attributes, 'id');
        $params = [
            'source_id' => $id,
            'source' => $this->client->getId(),
        ];
        return Auth::find()->where($params)->one();
    }

    /**
     * 
     * @param type $attributes
     * @return User|null
     */
    private function createAccount($attributes)
    {     
        $id = ArrayHelper::getValue($attributes, 'id');
        $name;
        $email;

        if($this->authclient == 'facebook' || $this->authclient == 'google'){
            $name = ArrayHelper::getValue($attributes, 'name');
            $name = preg_replace('/\s/', '', $name);
            $name = $this->convertUsernameToEnglish($name); 
            
            $email = ArrayHelper::getValue($attributes, 'email');
        }elseif($this->authclient == 'vkontakte'){
            $name = ArrayHelper::getValue($attributes, 'first_name').ArrayHelper::getValue($attributes, 'last_name');           
            $name = $this->convertUsernameToEnglish($name);           
            
            $email = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 7).'@mail.ru';
        }       

        $user = $this->createUser($name, $email);
        
        
        
        $user->save();
        $user->privileges = 'active';    
        $auth = Yii::$app->authManager;
        $active = $auth->getRole('active');
        $auth->assign($active, $user->getId());       
       
        
       
        $transaction = User::getDb()->beginTransaction();

        if ($user->save()) {
            $auth = $this->createAuth($user->id, $id);
            $auth->save();
            if ($auth->save()) {
               
                $transaction->commit();

                return $user;
            }
        }
        $transaction->rollBack();
    }

    private function createUser($name, $email)
    {
        return new User([
            'username' => $name,
            'displayname' => $name,
            'email' => $email,
            'password' => Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString()),
           
        ]);

    }

    private function createAuth($userId, $sourceId)
    {
        return new Auth([
            'user_id' => $userId,
            'source' => $this->client->getId(),
            'source_id' => (string) $sourceId,
        ]);
    }

    public function convertUsernameToEnglish($username){   
        
        function translit($username) {
            $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
            $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
            return str_replace($rus, $lat, $username);
          }
        return translit($username);
    }
}
?>