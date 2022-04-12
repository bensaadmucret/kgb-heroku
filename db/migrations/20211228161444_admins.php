<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Admins extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('administrateur')
            ->addColumn('nom', 'string', ['limit' => 255])
            ->addColumn('prenom', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255], ['unique' => true])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('role', 'string', ['limit' => 255])            
            ->addColumn('created_at', 'datetime')                
            ->create();

    }
    
    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('administrateur');
    }
}
