<?php

namespace AppBundle\DoctrineExtensions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * DateTrunc ::= "date_trunc" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class DateTrunc extends FunctionNode
{
    // (1)
    public $firstDateExpression = null;
    public $secondDateExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); // (2)
        $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
        $this->firstDateExpression = $parser->ArithmeticPrimary(); // (4)
        $parser->match(Lexer::T_COMMA); // (5)
        $this->secondDateExpression = $parser->ArithmeticPrimary(); // (6)
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'date_trunc(' .
        $this->firstDateExpression->dispatch($sqlWalker) . ', ' .
        $this->secondDateExpression->dispatch($sqlWalker) .
        ')'; // (7)
    }
}