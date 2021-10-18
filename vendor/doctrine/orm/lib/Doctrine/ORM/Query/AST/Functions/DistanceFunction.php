<?php

namespace Doctrine\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\Lexer;

class DistanceFunction extends FunctionNode
{

public $stringLatitude1;
public $stringLatitude2;
public $stringLongitude1;
public $stringLongitude2;
public $x;


public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
{
return $sqlWalker->getConnection()->getDatabasePlatform()->getDistanceExpression(
$sqlWalker->walkArithmeticFactor($this->stringLatitude1),
$sqlWalker->walkArithmeticFactor($this->stringLatitude2),
$sqlWalker->walkArithmeticFactor($this->stringLatitude11),
$sqlWalker->walkArithmeticFactor($this->stringLatitude22),
$sqlWalker->walkArithmeticFactor($this->stringLongitude1),
$sqlWalker->walkArithmeticFactor($this->stringLongitude2)
);
}

public function parse(\Doctrine\ORM\Query\Parser $parser)
{


$parser->match(Lexer::T_IDENTIFIER);
$parser->match(Lexer::T_OPEN_PARENTHESIS);
$this->stringLatitude1 = $parser->ArithmeticFactor();
$parser->match(Lexer::T_COMMA);
$this->stringLatitude2 = $parser->ArithmeticFactor();
$parser->match(Lexer::T_COMMA);
$this->stringLatitude11 = $parser->ArithmeticFactor();
$parser->match(Lexer::T_COMMA);
$this->stringLatitude22 = $parser->ArithmeticFactor();
$parser->match(Lexer::T_COMMA);
$this->stringLongitude1 = $parser->ArithmeticFactor();
$parser->match(Lexer::T_COMMA);
$this->stringLongitude2 = $parser->ArithmeticFactor();
$parser->match(Lexer::T_CLOSE_PARENTHESIS);

}
}