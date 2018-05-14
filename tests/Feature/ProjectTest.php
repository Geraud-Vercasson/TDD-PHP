<?php
/**
 * Created by PhpStorm.
 * User: geraud.vercasson
 * Date: 14/05/2018
 * Time: 15:57
 */

namespace Tests\Feature;

use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function testProjectGetRoute(){
        /*Essai d'accès à la page /project*/
        $response = $this->get('/project');
        /*code HTTP de retour attendu : 200*/
        $response->assertStatus(200);
        $response->assertSee("<h1>Liste des projets</h1>");
    }
}