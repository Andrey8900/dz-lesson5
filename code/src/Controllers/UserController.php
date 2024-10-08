namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;
use Geekbrains\Application1\Storage\UserStorage;

class UserController {
    public function saveAction()
    {
        // Get the user data from the GET request
        $name = $_GET['name'];
        $birthday = $_GET['birthday'];

        // Validate the user data
        if (empty($name) || empty($birthday)) {
            throw new Exception('Invalid user data');
        }

        // Create a new user object
        $user = new User();
        $user->setName($name);
        $user->setBirthday($birthday);

        // Save the user to the storage
        $userStorage = new UserStorage();
        $userStorage->save($user);

        // Return a success message
        echo 'User saved successfully!';
    }

    public function actionIndex() {
        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]);
        }
    }
}