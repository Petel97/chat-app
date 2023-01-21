<?php

// Verifier si notre fichier de donnees existe
function file_existe(){
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // verification de l'existance du fichier
    return file_exists($chemin);
}


// Retourne la liste des utilisateurs
function recurer_users($user_id=null)
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // verification de l'existance du fichier
    if(file_existe()) {
        // Retourne la liste des utilisateurs
        if($user_id == null) 
            return json_decode(file_get_contents($chemin))->users;
        else {
            $users = [];
            foreach (json_decode(file_get_contents($chemin))->users as $user) {
                if($user_id != $user->id) {
                    array_push($users, $user);
                }
            }

            return $users;
        }
    } else {
        // retourne un tableau si il n'y as pas d'utilisateur
        return [];
    }
}

// Retourne la liste des messages
function recurer_groupes()
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // verification de l'existance du fichier
    if(file_existe()) {
        // Retourne la liste des messages
        return json_decode(file_get_contents($chemin))->groupes;
    } else {
        // retourne un tableau si il n'y as pas d'utilisateur
        return [];
    }
}


// Retourne la liste des messages
function recurer_groupe_users()
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // verification de l'existance du fichier
    if(file_existe()) {
        // Retourne la liste des messages
        return json_decode(file_get_contents($chemin))->groupe_users;
    } else {
        // retourne un tableau si il n'y as pas d'utilisateur
        return [];
    }
}

// Retourne la liste des messages
function recurer_messages()
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // verification de l'existance du fichier
    if(file_existe()) {
        // Retourne la liste des messages
        return json_decode(file_get_contents($chemin))->messages;
    } else {
        // retourne un tableau si il n'y as pas d'utilisateur
        return [];
    }
}

// Retourne la liste des messages
function recurer_message_by_users($sender_id, $receiver_id)
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // verification de l'existance du fichier
    if(file_existe() && json_decode(file_get_contents($chemin))->messages) {
        // Retourne la liste des messages
        $group_u = groupe_by_users($sender_id, $receiver_id);
        if($group_u == null) {
            $groupe_id = creer_groupe_users($sender_id, $receiver_id);
        } else {
            $groupe_id = $group_u->groupe_id;
        }

        $messages = [];
        
        foreach (json_decode(file_get_contents($chemin))->messages as $msg) {
            if($groupe_id == $msg->groupe_id) {
                array_push($messages, $msg);
            }
        }

        return $messages;
    } else {
        // retourne un tableau si il n'y as pas d'utilisateur
        return [];
    }
}

function groupe_by_users($sender_id, $reveiver_id)
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // verification de l'existance du fichier
    if(file_existe()) {
        // Retourne la liste des messages
        foreach (json_decode(file_get_contents($chemin))->groupe_users as $grp_u) {
            if($sender_id == $grp_u->sender_id && $reveiver_id == $grp_u->receiver_id) {
                return $grp_u;
            }
            if($reveiver_id == $grp_u->sender_id && $sender_id == $grp_u->receiver_id) {
                return $grp_u;
            }
        }
        return null;
    } else {
        // retourne un tableau si il n'y as pas d'utilisateur
        return null;
    }
}

// Ajouter un utilisateur
function ajouter_utilisateur($donnee) {
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';
   
    // Retourne la liste des utilisateurs
    $user_lists = recurer_users();

    // Retourne la liste des messages
    $messages = recurer_messages();

    // Ajoute l'id de l'ilisateur courent
    $donnee["id"] = 1 + count($user_lists);

    // Ajout de l'itilisateur courent a la liste des utilisateur
    array_push($user_lists, $donnee);

    // Construction de notre liste d'utilisateur
    $data = [
        "users" => $user_lists,
        "messages" => $messages,
        "groupes" => recurer_groupes(),
        "groupe_users" => recurer_groupe_users()
    ];

    // Enregistrement des donnee de l'utilisateur dans le fichier en remplacement
    file_put_contents($chemin, json_encode($data));
    
    return true;

}


function connecter_utilisateur($username, $password) {
    // Retourne la liste des utilisateurs
    $user_lists = recurer_users();

    foreach ($user_lists as $user) {
        if($username == $user->username) {
            if(hash('ripemd160', $password) == $user->password) {
                return ["type" => "Success", "user" => $user];
            } else {
                return ["type" => "Erreur", "message" =>  "Votre mot de passe est incorrect"];
            }
        }
    }
    return ["type" => "Erreur", "message" =>  "Votre non d'utilisateur n'existe pas"];

}

function creer_message($message)
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';
   
    // Retourne la liste des utilisateurs
    $users = recurer_users();

    // Retourne la liste des utilisateurs
    $messages = recurer_messages();

     // Ajoute l'id de l'ilisateur courent
     $message["id"] = 1 + count($messages);

     // Ajout de l'itilisateur courent a la liste des utilisateur
    array_push($messages, $message);

    // Construction de notre liste d'utilisateur
    $data = [
        "users" => $users,
        "messages" => $messages,
        "groupes" => recurer_groupes(),
        "groupe_users" => recurer_groupe_users()
    ];

    // Enregistrement des donnee de l'utilisateur dans le fichier en remplacement
    file_put_contents($chemin, json_encode($data));
    
    return true;
}


function creer_groupe_users($sender_id, $receiver_id, $nom_groupe=null)
{
    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee.json';

    // Retourne la liste des utilisateurs
    $groupes = recurer_groupes();

     // Ajoute l'id de l'ilisateur courent
    $groupe_id = 1 + count($groupes);
     $groupe = [
        "id" => $groupe_id, 
        "nom" => $nom_groupe
     ];

     // Ajout de l'itilisateur courent a la liste des utilisateur
    array_push($groupes, $groupe);

     // Retourne la liste des utilisateurs
    $groupe_users = recurer_groupe_users();

    // Ajoute l'id de l'ilisateur courent
    $groupe_user = [
       "id" => 1 + count($groupe_users), 
       "sender_id" => (int)$sender_id,
       "receiver_id" => (int)$receiver_id,
       "groupe_id" => $groupe_id,
    ];

    array_push($groupe_users, $groupe_user);


    // Construction de notre liste d'utilisateur
    $data = [
        "users" => recurer_users(),
        "messages" => recurer_messages(),
        "groupes" => $groupes,
        "groupe_users" => $groupe_users
    ];

    // Enregistrement des donnee de l'utilisateur dans le fichier en remplacement
    file_put_contents($chemin, json_encode($data));
    
    return $groupe_id;
}

