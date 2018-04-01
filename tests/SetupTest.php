<?php
use PHPUnit\Framework\TestCase;

class SetupTest extends TestCase 
{
    private $javadocStart = "\t/**".PHP_EOL;
    private $javadocEnd   = "\t */".PHP_EOL;

    public static function setUpBeforeClass()
    {
        require_once __DIR__."/../src/setup.php";
    }

    public function testMakeKeysCaseInsensitive()
    {
        $caseSensitiveArray=[
            'Test1' => 'test',
            'test2' => 'Test2',
            'Test3' => 'Test3'
        ];
        $expected = [
            'test1' => 'test',
            'test2' => 'Test2',
            'test3' => 'Test3'
        ];
        makeKeysCaseInsensitive($caseSensitiveArray);
        $this->assertEquals($expected,$caseSensitiveArray);
    }
    public function testGetJavadocAsEmptyArray()
    {
        $expected = $this->javadocStart.$this->javadocEnd;
        $this->assertEquals($expected,getJavaDoc(array()));
    }
    public function testGetJavadocAsJavadocString()
    {
        $comment = 'javadoc string';
        $expected = $this->javadocStart.$comment.PHP_EOL.$this->javadocEnd;
        $this->assertEquals($expected,getJavaDoc(array('javadoc' => $comment)));
    }
    public function testGetJavadocCommentAsString()
    {
        $comment = 'comment string';
        $expected = $this->javadocStart."\t * ".$comment.PHP_EOL.$this->javadocEnd;
        $this->assertEquals($expected,getJavaDoc(array('javadoc'=>array('comment'=>$comment))));
    }
    public function testGetJavadocCommentAsArray()
    {
        $comment = array('comment1','comment2');
        $expected = $this->javadocStart;
        foreach ($comment as $com) {
            $expected.= "\t * ".$com.PHP_EOL;
        }
        $expected.=$this->javadocEnd;
        $this->assertEquals($expected,getJavaDoc(array('javadoc'=>array('comment'=>$comment))));
    }
    public function testGetJavadocAuthorAndReturnNotSet()
    {
        $author = null;
        $return = $author;
        $expected=$this->javadocStart.$this->javadocEnd;
        $this->assertEquals($expected,getJavaDoc(array('javadoc'=>array('author' => $author,'return' => $return))));
    }
    public function testGetJavadocAuthorAndReturnAsString()
    {
        $author = 'author';
        $return = 'return';
        $expected=$this->javadocStart."\t * @return ".$return;
        $expected.="\t * @author ".$author.$this->javadocEnd;
        $this->assertEquals($expected,getJavaDoc(array('javadoc'=>array('author' => $author,'return'=>$return))));
    }
    /**
     * @expectedException PHPUnit\Framework\Error\Notice
     */
    public function testGetJavadocAuthorAndReturnAsArray()
    {
        $author = array('dsqd','dsqsd');
        $return = $author;
        $expected = $this->javadocStart.$this->javadocEnd;
        $this->assertEquals($expected,getJavaDoc(array('javadoc'=>array('author' => $author,'return'=>$return))));
    }
}