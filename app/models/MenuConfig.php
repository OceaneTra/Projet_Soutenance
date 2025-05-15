<?php

require_once __DIR__ . '/../config/DbModel.class.php';

class MenuConfig extends DbModel
{
    public function getMenuByRole($role): array
    {
        return $this->selectAll(
            "SELECT * FROM menu_config 
             WHERE role = ? AND is_active = TRUE 
             ORDER BY parent_id IS NULL DESC, display_order, label",
            [$role]
        );
    }

    public function getAllMenus(): array
    {
        return $this->selectAll(
            "SELECT * FROM menu_config ORDER BY role, display_order",
            [],
            true
        );
    }

    public function addMenuItem($data): int
    {
        return $this->insert(
            "INSERT INTO menu_config (role, slug, label, icon, parent_id, display_order, is_active)
             VALUES (:role, :slug, :label, :icon, :parent_id, :display_order, :is_active)",
            $data
        );
    }

    public function updateMenuItem($id, $data): int
    {
        $data['id'] = $id;
        return $this->update(
            "UPDATE menu_config SET 
                role = :role, 
                slug = :slug, 
                label = :label, 
                icon = :icon, 
                parent_id = :parent_id, 
                display_order = :display_order, 
                is_active = :is_active 
             WHERE id = :id",
            $data
        );
    }

    public function deleteMenuItem($id): int
    {
        return $this->delete("DELETE FROM menu_config WHERE id = ?", [$id]);
    }
}