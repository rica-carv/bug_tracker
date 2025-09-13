<?php
if (!defined('e107_INIT')) { exit; }

class bug_tracker_event
{
    /**
     * Listener para o evento 'postuserset'
     * Corre sempre que um utilizador atualiza o seu perfil
     */
    public function onPostUserSet($data)
    {
        $sql = e107::getDb();
        $tp  = e107::getParser();

        if (!empty($data['username']))
        {
            if ($sql->select('user', 'user_id', 'user_name = "' . $tp->toDB($data['username']) . '"'))
            {
                $row = $sql->fetch();
                if (!empty($row['user_id']))
                {
                    $newname = $row['user_id'] . "." . $data['username'];
                    $sql->update(
                        'bugtrack_bugs',
                        'bugtrack_author = "' . $tp->toDB($newname) . '" 
                         WHERE SUBSTRING_INDEX(bugtrack_author,".",1)="' . intval($row['user_id']) . '"'
                    );
                }
            }
        }
    }
}
