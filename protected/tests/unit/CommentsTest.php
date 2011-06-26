<?php
class CommentsTest extends CDbTestCase {
    public $fixtures = array(
        'articles' => 'Article',
        'comments' => 'Comment',
    );

    public function testSaveArticle() {
        $article = $this->articles('sample1');
        $this->assertTrue($article->save());
        $dbArticle = Article::model()->findByPk($article);
        $this->assertTrue($dbArticle instanceof $article);
    }

    public function testSaveComment() {
        $comment = new Comment();
        $comment->attributes = array(
            'name' => 'test test',
            'text' => 'Содержимое тестовой записи 1',
        );

        $this->assertTrue($comment->save());
        $dbComment = Comment::model()->findByPk($comment->id);
        $this->assertTrue($dbComment instanceof Comment);
    }

    public function testAttachCommentToArticle() {
        $article = $this->articles('sample1');
        $article->save();
        $article->attachBehavior('CommentableBehavior', new CommentableBehavior())

        $comments = $article->findComments();
        foreach($comments as $comment){
            $article->deleteComment($comment);
        }

        $comment = $this->comments('sample1');
        $article->addComment($comment);
        $comments = $article->findComments();
        
        $this->assertTrue(count($comments) != 0);
        CVarDumper::dump(count($comments));

        $this->assertTrue(count($comments) == 1);
        $this->assertTrue($comments[0] instanceof Comment);
        $this->assertEquals($comment->name, $comments[0]->name);
    }


    public function testFindComments()
    {
        $article1 = $this->articles('sample1');
        $article1->save();
        $article1->attachBehavior('CommentableBehavior', new CommentableBehavior());
        $comments = $article1->findComments();
        foreach($comments as $comment){
            $article1->deleteComment($comment);
        }
        
        $article2  = $this->articles('sample2');
        $article2->save();
        $comments = $article2->findComments();
        foreach($comments as $comment){
            $article2->deleteComment($comment);
        }
        
        $article2->attachBehavior('CommentableBehavior', new CommentableBehavior());

        $article1->addComment($this->comments('sample1'));
        $article1->addComments($this->comments('sample2'));

        $article2->addComment($this->comments('sample3'));
        $article2->addComments($this->comments('sample4'));

        $comments1 = $article1->findComments();
        $this->assertTrue(count($comments1)==2);
    }

    public function testDeleteComment() {
        $article = $this->articles('sample1');
        $article->attachBehavior('CommentableBehavior', new CommentableBehavior());
        $article->save();
        $comment = $this->comments('sample1');
        $article->addComment($comment);
        $this->assertTrue(count($article->findComments())!=0);
        $comments = $article->findComments();
        foreach($comments as $comment){
            $article->deleteComment($comment);
        }
        $comments = $article->findComments();
        $this->assertTrue(count($comments)==0);
    }
}
