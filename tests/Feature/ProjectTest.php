<?php
/**
 * Created by PhpStorm.
 * User: geraud.vercasson
 * Date: 14/05/2018
 * Time: 15:57
 */

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use DatabaseMigrations;

    public function testProjectGetRoute(){

        factory(Project::class, 5)->create();

        /*Essai d'accès à la page /project*/
        $response = $this->get('/project');
        /*code HTTP de retour attendu : 200*/
        $response->assertStatus(200);
        $response->assertSee("Liste des projets");

        $testedProject = Project::all()->random();
        // Vérification de la présence du nom du projet dans la page
        $response->assertSee($testedProject->name);
    }

    public function testProjectDetails(){

        factory(Project::class, 5)->create();

        $testedProject = Project::all()->random();
        $url = '/project/' . $testedProject->id;

        $response = $this->get($url);
        //la page de détails doit apparaitre (
        $response->assertStatus(200);
        $response->assertSee($testedProject->name);
    }

    public function testRelation(){
        factory(Project::class, 5)->create();
        $testedProject = Project::all()->random();
        $testedUser = $testedProject->user;
        $this->assertInstanceOf(User::class, $testedUser);
    }

    public function testAuthorName(){
        factory(Project::class, 5)->create();
        $testedProject = Project::all()->random();
        $testedUser = $testedProject->user;

        $response = $this->get('/project/'.$testedProject->id);
        $response->assertSee($testedUser->name);
    }

    public function testPostAvailableToAuthenticatedUser(){

        factory(User::class, 1)->create();
        $testedUser = User::all()->first();
        $project = factory(Project::class)->make();
        $postData = ['name' => $project->name,
                    'description' => $project->description,
                    '_token' => csrf_token()];

        $response = $this->actingAs($testedUser)->post('/project/create', $postData);

        $response->assertRedirect('/project');

        $projectInDb = Project::all()->first();
        $this->assertEquals($project->name, $projectInDb->name);
        $this->assertEquals($project->description, $projectInDb->description);
        $this->assertEquals($testedUser->id, $projectInDb->id);
    }
    public function testPostUnavailableToUnregisteredUser(){

        $project = factory(Project::class)->make();
        $postData = ['name' => $project->name,
            'description' => $project->description,
            '_token' => csrf_token()];

        $response = $this->post('/project/create', $postData);
        //Vérifie la redirection
        $response->assertRedirect('/login');

        $projectsInDB = Project::all();
        //Vérifie que le projet posté est bien absent des projets enregistrés
        $this->assertEquals(true,$projectsInDB->isEmpty());
    }

    public function testCreateFormUnavailableToUnregisteredUser(){
        $response = $this->get('/project/add');
        $response->assertDontSee('/project/create');
        $response->assertRedirect('/login');
    }

    public function testEditAvailableOnlyToAuthor(){
        $project = factory(Project::class)->create();
        $author = $project->user;

        $anotherUser = factory(User::class)->create();

        $postInputs = ['name' => 'test',
                        'description' => 'test description',
                        '_token' => csrf_token()];

        $response = $this->actingAs($author)->post('/project/edit/' . $project->id, $postInputs);
        //L'auteur est redirigé vers la page des détails de son projet
        $response->assertRedirect('/project/' . $project->id);

        $projectInDB = Project::find($project->id);
        //Vérification de l'enregistrement des données
        $this->assertEquals($postInputs['name'], $projectInDB->name);
        $this->assertEquals($postInputs['description'], $projectInDB->description);

        //Nouvelles données pour un utilisateur enregistré qui n'est pas l'auteur du projet
        $postInputs = ['name' => 'testfail',
            'description' => 'testfail description',
            '_token' => csrf_token()];
        //Un autre utilisateur est redirigé vers la liste des projets

        $response = $this->actingAs($anotherUser)->post('/project/edit/' . $project->id, $postInputs);
        $response->assertRedirect('/project');

        $projectInDB = Project::find($project->id);
        //Vérification des données originales
        $this->assertNotEquals($postInputs['name'], $projectInDB->name);
        $this->assertNotEquals($postInputs['description'], $projectInDB->description);
    }
}