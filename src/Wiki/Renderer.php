<?php
namespace Core3\Wiki;

class Renderer
{
    public static function render($articleName, $db)
    {
        $article = $db->selectToObject(
            '\Core3\Wiki\Revision',
            'SELECT a.name,r.* FROM wikiArticle a'.
            ' INNER JOIN wikiRevision r ON (a.revisionId=r.id)'.
            ' WHERE name = :name',
            array('name' => $articleName)
        );

        return \Core3\Present\Markdown::render($article->text);
    }
}
