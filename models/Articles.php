<?php

declare(strict_types=1);

/**
 * =============================================
 * ================             ================
 * Articles Model
 * ================             ================
 * =============================================
 */

namespace PhpStrike\models;


use celionatti\Bolt\Database\DatabaseModel;

class Articles extends DatabaseModel
{
    private $scenario = 'create'; // Default scenario is 'create'

    public static function tableName(): string
    {
        return 'articles';
    }

    public function setIsInsertionScenario(string $scenario)
    {
        // You can validate the scenario here if needed
        $this->scenario = $scenario;
    }

    public function rules(string $scenario = null): array
    {
        // Define validation rules for different scenarios
        $rules = [
            'create' => [
                'title' => [
                    ['rule' => 'required', 'message' => 'Article Title is required.'],
                ],
                'content' => [
                    ['rule' => 'required', 'message' => 'Article Content is required.'],
                ],
                'tags' => [
                    ['rule' => 'required', 'message' => 'Article Tags is required.'],
                ],
                'authors' => [
                    ['rule' => 'required', 'message' => 'Article Authors is required.'],
                ],
                'thumbnail_caption' => [
                    ['rule' => 'required', 'message' => 'Article Thumbnail Caption is required.'],
                ],
                'image_caption' => [
                    ['rule' => 'required', 'message' => 'Article Image Caption is required.'],
                ],
                'meta_title' => [
                    ['rule' => 'required', 'message' => 'Article Meta Title is required.'],
                ],
                'meta_description' => [
                    ['rule' => 'required', 'message' => 'Article Meta Descriptions is required.'],
                ],
                'meta_keywords' => [
                    ['rule' => 'required', 'message' => 'Article Meta Keywords is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Article Status is required.'],
                ],
            ],
            'edit' => [
                'title' => [
                    ['rule' => 'required', 'message' => 'Article Title is required.'],
                ],
                'content' => [
                    ['rule' => 'required', 'message' => 'Article Content is required.'],
                ],
                'tags' => [
                    ['rule' => 'required', 'message' => 'Article Tags is required.'],
                ],
                'authors' => [
                    ['rule' => 'required', 'message' => 'Article Authors is required.'],
                ],
                'thumbnail_caption' => [
                    ['rule' => 'required', 'message' => 'Article Thumbnail Caption is required.'],
                ],
                'image_caption' => [
                    ['rule' => 'required', 'message' => 'Article Image Caption is required.'],
                ],
                'meta_title' => [
                    ['rule' => 'required', 'message' => 'Article Meta Title is required.'],
                ],
                'meta_description' => [
                    ['rule' => 'required', 'message' => 'Article Meta Descriptions is required.'],
                ],
                'meta_keywords' => [
                    ['rule' => 'required', 'message' => 'Article Meta Keywords is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Article Status is required.'],
                ],
            ],
        ];

        // Determine the scenario to use or fallback to the default
        $scenario = $scenario ?: $this->scenario;

        return $rules[$scenario] ?? [];
    }

    public function beforeSave(): void
    {
    }

    public function getEditorsPick()
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['is_editors_pick' => 'true'])
            ->orderBy("created_at", "DESC")
            ->get()[0] ?? null;
    }

    public function getTrendingArticles()
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['status' => 'publish'])
            ->orderBy("views", "DESC")
            ->limit(4)
            ->get();
    }

    public function getRecentArticles()
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['status' => 'publish'])
            ->orderBy("created_at", "DESC")
            ->limit(3)
            ->get();
    }

    public function getArticleTags()
    {
        return $this->getQueryBuilder()
            ->select("tags")
            ->where(['status' => 'publish'])
            ->orderBy("views", "DESC")
            ->get();
    }

    public function getArticleAuthor($id)
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['user_id' => $id])
            ->orderBy("created_at", "DESC")
            ->get();
    }

    public function getArticleAuthors()
    {
        return $this->getQueryBuilder()
            ->rawQuery("SELECT u.*, COUNT(a.article_id) AS total_articles
            FROM users u
            JOIN articles a ON u.user_id = a.user_id
            GROUP BY u.user_id
            ")
            ->get();
    }

    public function increaseView($id)
    {
        return $this->getQueryBuilder()
            ->rawQuery("UPDATE articles SET views = views + 1 WHERE article_id = :article_id", ['article_id' => $id])
            ->execute();
    }

    public function getPopularArticles($limit)
    {
        $query = "SELECT a.* FROM articles a 
                  LEFT JOIN comments c ON a.article_id = c.article_id 
                  GROUP BY a.article_id
                  ORDER BY a.views DESC, COUNT(c.comment_id) DESC LIMIT :limit";

        return $this->getQueryBuilder()
            ->rawQuery($query, ['limit' => $limit])
            ->get()[0] ?? null;
    }


    public function articleChart()
    {
        $articleData = $this->executeRawQuery("SELECT DATE_FORMAT(created_at, '%Y-%m') AS months, COUNT(*) AS article_count FROM articles GROUP BY months ORDER BY months");

        // Prepare data for charting
        $months = [];
        $articleCounts = [];

        foreach ($articleData as $data) {
            $months[] = $data->months;
            $articleCounts[] = $data->article_count;
        }

        return ['months' => $months, 'articleCounts' => $articleCounts];
    }
}