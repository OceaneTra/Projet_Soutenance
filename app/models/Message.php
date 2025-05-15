<?php

require_once __DIR__ . '/../config/DbModel.class.php';
class Message extends DbModel
{
    public function ajouterMessage($contenu_message): int
    {
        return $this->insert("INSERT INTO messages (contenu_message) VALUES (?)", [$contenu_message]);
    }

    public function updateMessage($id_message, $contenu_message): int
    {
        return $this->update("UPDATE messages SET contenu_message = ? WHERE id_message = ?", [$contenu_message, $id_message]);
    }

    public function deleteMessage($id_message): int
    {
        return $this->delete("DELETE FROM messages WHERE id_message = ?", [$id_message]);
    }

    public function getMessageById($id_message): object|array|null
    {
        return $this->selectOne("SELECT * FROM messages WHERE id_message = ?", [$id_message], true);
    }

    public function getAllMessages(): array
    {
        return $this->selectAll("SELECT * FROM messages ORDER BY contenu_message", [], true);
    }
}