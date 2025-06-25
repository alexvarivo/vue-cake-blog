<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');

        // Public access
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    // GET /articles
    public function index()
    {
        $articles = $this->Articles->find()->all();

        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($articles));

        return $this->response;
    }

    // GET /articles/:id
    public function view($id = null)
    {
        $this->request->allowMethod(['get']);

        try {
            $article = $this->Articles->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            return $this->response
                ->withStatus(404)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Article not found']));
        }
    
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['article' => $article]));
    }

    // POST /articles/add
    public function add()
    {
        $this->request->allowMethod(['post']);

        $result = $this->Authentication->getResult();
        if (!$result->isValid()) {
            return $this->response
                ->withStatus(401)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Unauthorized']));
        }

        $article = $this->Articles->newEmptyEntity();
        $article = $this->Articles->patchEntity($article, $this->request->getData());

        if ($this->Articles->save($article)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode(['message' => 'Article saved']));
        }

        return $this->response
            ->withStatus(400)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => 'Failed to save article']));
    }

    // DELETE /articles/:id
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);

        $result = $this->Authentication->getResult();
        if (!$result->isValid()) {
            return $this->response
                ->withStatus(401)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Unauthorized']));
        }

        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode(['message' => 'Article deleted']));
        }

        return $this->response
            ->withStatus(400)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => 'Failed to delete article']));
    }
}
