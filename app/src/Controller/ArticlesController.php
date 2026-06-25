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
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    public function index()
    {
        $this->request->allowMethod(['get']);
        $articles = $this->Articles->find()->all();

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($articles));
    }

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
            ->withStringBody(json_encode($article));
    }

    public function add()
    {
        $this->request->allowMethod(['post']);

        $article = $this->Articles->newEmptyEntity();
        $article = $this->Articles->patchEntity($article, $this->request->getData());

        if ($this->Articles->save($article)) {
            return $this->response
                ->withStatus(201)
                ->withType('application/json')
                ->withStringBody(json_encode(['message' => 'Article saved', 'article' => $article]));
        }

        return $this->response
            ->withStatus(422)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => 'Failed to save article', 'errors' => $article->getErrors()]));
    }

    public function edit($id = null)
    {
        $this->request->allowMethod(['put', 'patch']);

        try {
            $article = $this->Articles->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            return $this->response
                ->withStatus(404)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Article not found']));
        }

        $article = $this->Articles->patchEntity($article, $this->request->getData());

        if ($this->Articles->save($article)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode(['message' => 'Article updated', 'article' => $article]));
        }

        return $this->response
            ->withStatus(422)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => 'Failed to update article', 'errors' => $article->getErrors()]));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);

        try {
            $article = $this->Articles->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            return $this->response
                ->withStatus(404)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Article not found']));
        }

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
