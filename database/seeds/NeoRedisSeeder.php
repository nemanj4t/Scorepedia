<?php

use Illuminate\Database\Seeder;
use Ahsan\Neo4j\Facade\Cypher;

class NeoRedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cypher::run("CREATE (b:Something {atr: 2})");
    }
}
