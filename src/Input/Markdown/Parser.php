<?php

namespace hanneskod\readmetester\Input\Markdown;

use hanneskod\readmetester\Attributes\Name;
use hanneskod\readmetester\Input\AbstractPhpegParser;
use hanneskod\readmetester\Input\Definition;
use hanneskod\readmetester\Input\Template;

class Parser extends AbstractPhpegParser
{
    protected function parseFILE()
    {
        $_position = $this->position;

        if (isset($this->cache['FILE'][$_position])) {
            $_success = $this->cache['FILE'][$_position]['success'];
            $this->position = $this->cache['FILE'][$_position]['position'];
            $this->value = $this->cache['FILE'][$_position]['value'];

            return $_success;
        }

        $_value9 = array();

        $_position1 = $this->position;
        $_cut2 = $this->cut;

        $this->cut = false;
        $_success = $this->parseGLOBAL_ATTRIBUTES_BLOCK();

        if (!$_success && !$this->cut) {
            $_success = true;
            $this->position = $_position1;
            $this->value = null;
        }

        $this->cut = $_cut2;

        if ($_success) {
            $global = $this->value;
        }

        if ($_success) {
            $_value9[] = $this->value;

            $_value4 = array();
            $_cut5 = $this->cut;

            while (true) {
                $_position3 = $this->position;

                $this->cut = false;
                $_success = $this->parseEXAMPLE();

                if (!$_success) {
                    break;
                }

                $_value4[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position3;
                $this->value = $_value4;
            }

            $this->cut = $_cut5;

            if ($_success) {
                $examples = $this->value;
            }
        }

        if ($_success) {
            $_value9[] = $this->value;

            $_value7 = array();
            $_cut8 = $this->cut;

            while (true) {
                $_position6 = $this->position;

                $this->cut = false;
                if ($this->position < strlen($this->string)) {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, 1);
                    $this->position += 1;
                } else {
                    $_success = false;
                }

                if (!$_success) {
                    break;
                }

                $_value7[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position6;
                $this->value = $_value7;
            }

            $this->cut = $_cut8;
        }

        if ($_success) {
            $_value9[] = $this->value;

            $this->value = $_value9;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$global, &$examples) {
                return new Template(array_values((array)$global), $examples);
            });
        }

        $this->cache['FILE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'FILE');
        }

        return $_success;
    }

    protected function parseGLOBAL_ATTRIBUTES_BLOCK()
    {
        $_position = $this->position;

        if (isset($this->cache['GLOBAL_ATTRIBUTES_BLOCK'][$_position])) {
            $_success = $this->cache['GLOBAL_ATTRIBUTES_BLOCK'][$_position]['success'];
            $this->position = $this->cache['GLOBAL_ATTRIBUTES_BLOCK'][$_position]['position'];
            $this->value = $this->cache['GLOBAL_ATTRIBUTES_BLOCK'][$_position]['value'];

            return $_success;
        }

        $_value15 = array();

        if (substr($this->string, $this->position, strlen('<!--')) === '<!--') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('<!--'));
            $this->position += strlen('<!--');
        } else {
            $_success = false;

            $this->report($this->position, '\'<!--\'');
        }

        if ($_success) {
            $_value15[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value15[] = $this->value;

            $_position10 = $this->position;
            $_cut11 = $this->cut;

            $this->cut = false;
            $_success = $this->parseATTRIBUTE();

            if (!$_success && !$this->cut) {
                $this->position = $_position10;

                $_success = $this->parseIGNORED_BLOCK_CONTENT();
            }

            $this->cut = $_cut11;

            if ($_success) {
                $_value13 = array($this->value);
                $_cut14 = $this->cut;

                while (true) {
                    $_position12 = $this->position;

                    $this->cut = false;
                    $_position10 = $this->position;
                    $_cut11 = $this->cut;

                    $this->cut = false;
                    $_success = $this->parseATTRIBUTE();

                    if (!$_success && !$this->cut) {
                        $this->position = $_position10;

                        $_success = $this->parseIGNORED_BLOCK_CONTENT();
                    }

                    $this->cut = $_cut11;

                    if (!$_success) {
                        break;
                    }

                    $_value13[] = $this->value;
                }

                if (!$this->cut) {
                    $_success = true;
                    $this->position = $_position12;
                    $this->value = $_value13;
                }

                $this->cut = $_cut14;
            }

            if ($_success) {
                $attributes = $this->value;
            }
        }

        if ($_success) {
            $_value15[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value15[] = $this->value;

            $_success = $this->parseBLOCK_END();
        }

        if ($_success) {
            $_value15[] = $this->value;

            $this->value = $_value15;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$attributes) {
                return array_filter($attributes);
            });
        }

        $this->cache['GLOBAL_ATTRIBUTES_BLOCK'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'GLOBAL_ATTRIBUTES_BLOCK');
        }

        return $_success;
    }

    protected function parseIGNORED_BLOCK_CONTENT()
    {
        $_position = $this->position;

        if (isset($this->cache['IGNORED_BLOCK_CONTENT'][$_position])) {
            $_success = $this->cache['IGNORED_BLOCK_CONTENT'][$_position]['success'];
            $this->position = $this->cache['IGNORED_BLOCK_CONTENT'][$_position]['position'];
            $this->value = $this->cache['IGNORED_BLOCK_CONTENT'][$_position]['value'];

            return $_success;
        }

        $_value20 = array();

        $_position18 = $this->position;
        $_cut19 = $this->cut;

        $this->cut = false;
        $_position16 = $this->position;
        $_cut17 = $this->cut;

        $this->cut = false;
        $_success = $this->parseBLOCK_END();

        if (!$_success && !$this->cut) {
            $this->position = $_position16;

            $_success = $this->parseATTRIBUTE_START();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position16;

            $_success = $this->parseCODE_START();
        }

        $this->cut = $_cut17;

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position18;
        $this->cut = $_cut19;

        if ($_success) {
            $_value20[] = $this->value;

            if ($this->position < strlen($this->string)) {
                $_success = true;
                $this->value = substr($this->string, $this->position, 1);
                $this->position += 1;
            } else {
                $_success = false;
            }
        }

        if ($_success) {
            $_value20[] = $this->value;

            $this->value = $_value20;
        }

        if ($_success) {
            $_value22 = array($this->value);
            $_cut23 = $this->cut;

            while (true) {
                $_position21 = $this->position;

                $this->cut = false;
                $_value20 = array();

                $_position18 = $this->position;
                $_cut19 = $this->cut;

                $this->cut = false;
                $_position16 = $this->position;
                $_cut17 = $this->cut;

                $this->cut = false;
                $_success = $this->parseBLOCK_END();

                if (!$_success && !$this->cut) {
                    $this->position = $_position16;

                    $_success = $this->parseATTRIBUTE_START();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position16;

                    $_success = $this->parseCODE_START();
                }

                $this->cut = $_cut17;

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position18;
                $this->cut = $_cut19;

                if ($_success) {
                    $_value20[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value20[] = $this->value;

                    $this->value = $_value20;
                }

                if (!$_success) {
                    break;
                }

                $_value22[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position21;
                $this->value = $_value22;
            }

            $this->cut = $_cut23;
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return null;
            });
        }

        $this->cache['IGNORED_BLOCK_CONTENT'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'IGNORED_BLOCK_CONTENT');
        }

        return $_success;
    }

    protected function parseBLOCK_END()
    {
        $_position = $this->position;

        if (isset($this->cache['BLOCK_END'][$_position])) {
            $_success = $this->cache['BLOCK_END'][$_position]['success'];
            $this->position = $this->cache['BLOCK_END'][$_position]['position'];
            $this->value = $this->cache['BLOCK_END'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen('-->')) === '-->') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('-->'));
            $this->position += strlen('-->');
        } else {
            $_success = false;

            $this->report($this->position, '\'-->\'');
        }

        $this->cache['BLOCK_END'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'BLOCK_END');
        }

        return $_success;
    }

    protected function parseEXAMPLE()
    {
        $_position = $this->position;

        if (isset($this->cache['EXAMPLE'][$_position])) {
            $_success = $this->cache['EXAMPLE'][$_position]['success'];
            $this->position = $this->cache['EXAMPLE'][$_position]['position'];
            $this->value = $this->cache['EXAMPLE'][$_position]['value'];

            return $_success;
        }

        $_value26 = array();

        $_position24 = $this->position;
        $_cut25 = $this->cut;

        $this->cut = false;
        $_success = $this->parseATTRIBUTES();

        if (!$_success && !$this->cut) {
            $_success = true;
            $this->position = $_position24;
            $this->value = null;
        }

        $this->cut = $_cut25;

        if ($_success) {
            $attributes = $this->value;
        }

        if ($_success) {
            $_value26[] = $this->value;

            $_success = $this->parseCODE();

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value26[] = $this->value;

            $this->value = $_value26;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$attributes, &$code) {
                return new Definition((array)$attributes, $code);
            });
        }

        $this->cache['EXAMPLE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'EXAMPLE');
        }

        return $_success;
    }

    protected function parseATTRIBUTES()
    {
        $_position = $this->position;

        if (isset($this->cache['ATTRIBUTES'][$_position])) {
            $_success = $this->cache['ATTRIBUTES'][$_position]['success'];
            $this->position = $this->cache['ATTRIBUTES'][$_position]['position'];
            $this->value = $this->cache['ATTRIBUTES'][$_position]['value'];

            return $_success;
        }

        $_position27 = $this->position;
        $_cut28 = $this->cut;

        $this->cut = false;
        $_success = $this->parseHEADER();

        if (!$_success && !$this->cut) {
            $this->position = $_position27;

            $_success = $this->parseATTRIBUTE();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position27;

            $_success = $this->parseIGNORED_CONTENT();
        }

        $this->cut = $_cut28;

        if ($_success) {
            $_value30 = array($this->value);
            $_cut31 = $this->cut;

            while (true) {
                $_position29 = $this->position;

                $this->cut = false;
                $_position27 = $this->position;
                $_cut28 = $this->cut;

                $this->cut = false;
                $_success = $this->parseHEADER();

                if (!$_success && !$this->cut) {
                    $this->position = $_position27;

                    $_success = $this->parseATTRIBUTE();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position27;

                    $_success = $this->parseIGNORED_CONTENT();
                }

                $this->cut = $_cut28;

                if (!$_success) {
                    break;
                }

                $_value30[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position29;
                $this->value = $_value30;
            }

            $this->cut = $_cut31;
        }

        if ($_success) {
            $attributes = $this->value;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$attributes) {
                return array_values(array_filter($attributes));
            });
        }

        $this->cache['ATTRIBUTES'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ATTRIBUTES');
        }

        return $_success;
    }

    protected function parseATTRIBUTE()
    {
        $_position = $this->position;

        if (isset($this->cache['ATTRIBUTE'][$_position])) {
            $_success = $this->cache['ATTRIBUTE'][$_position]['success'];
            $this->position = $this->cache['ATTRIBUTE'][$_position]['position'];
            $this->value = $this->cache['ATTRIBUTE'][$_position]['value'];

            return $_success;
        }

        $_value39 = array();

        $_success = $this->parseATTRIBUTE_START();

        if ($_success) {
            $_value39[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value39[] = $this->value;

            $_position38 = $this->position;

            $_value36 = array();
            $_cut37 = $this->cut;

            while (true) {
                $_position35 = $this->position;

                $this->cut = false;
                $_value34 = array();

                $_position32 = $this->position;
                $_cut33 = $this->cut;

                $this->cut = false;
                $_success = $this->parseATTRIBUTE_END();

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position32;
                $this->cut = $_cut33;

                if ($_success) {
                    $_value34[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value34[] = $this->value;

                    $this->value = $_value34;
                }

                if (!$_success) {
                    break;
                }

                $_value36[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position35;
                $this->value = $_value36;
            }

            $this->cut = $_cut37;

            if ($_success) {
                $this->value = strval(substr($this->string, $_position38, $this->position - $_position38));
            }

            if ($_success) {
                $attr = $this->value;
            }
        }

        if ($_success) {
            $_value39[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value39[] = $this->value;

            $_success = $this->parseATTRIBUTE_END();
        }

        if ($_success) {
            $_value39[] = $this->value;

            $this->value = $_value39;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$attr) {
                return $attr;
            });
        }

        $this->cache['ATTRIBUTE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ATTRIBUTE');
        }

        return $_success;
    }

    protected function parseATTRIBUTE_START()
    {
        $_position = $this->position;

        if (isset($this->cache['ATTRIBUTE_START'][$_position])) {
            $_success = $this->cache['ATTRIBUTE_START'][$_position]['success'];
            $this->position = $this->cache['ATTRIBUTE_START'][$_position]['position'];
            $this->value = $this->cache['ATTRIBUTE_START'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen('#[')) === '#[') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('#['));
            $this->position += strlen('#[');
        } else {
            $_success = false;

            $this->report($this->position, '\'#[\'');
        }

        $this->cache['ATTRIBUTE_START'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ATTRIBUTE_START');
        }

        return $_success;
    }

    protected function parseATTRIBUTE_END()
    {
        $_position = $this->position;

        if (isset($this->cache['ATTRIBUTE_END'][$_position])) {
            $_success = $this->cache['ATTRIBUTE_END'][$_position]['success'];
            $this->position = $this->cache['ATTRIBUTE_END'][$_position]['position'];
            $this->value = $this->cache['ATTRIBUTE_END'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen(']')) === ']') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen(']'));
            $this->position += strlen(']');
        } else {
            $_success = false;

            $this->report($this->position, '\']\'');
        }

        $this->cache['ATTRIBUTE_END'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ATTRIBUTE_END');
        }

        return $_success;
    }

    protected function parseHEADER()
    {
        $_position = $this->position;

        if (isset($this->cache['HEADER'][$_position])) {
            $_success = $this->cache['HEADER'][$_position]['success'];
            $this->position = $this->cache['HEADER'][$_position]['position'];
            $this->value = $this->cache['HEADER'][$_position]['value'];

            return $_success;
        }

        $_position40 = $this->position;
        $_cut41 = $this->cut;

        $this->cut = false;
        $_success = $this->parseATX_HEADER();

        if (!$_success && !$this->cut) {
            $this->position = $_position40;

            $_success = $this->parseSETEXT_HEADER();
        }

        $this->cut = $_cut41;

        $this->cache['HEADER'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'HEADER');
        }

        return $_success;
    }

    protected function parseATX_HEADER()
    {
        $_position = $this->position;

        if (isset($this->cache['ATX_HEADER'][$_position])) {
            $_success = $this->cache['ATX_HEADER'][$_position]['success'];
            $this->position = $this->cache['ATX_HEADER'][$_position]['position'];
            $this->value = $this->cache['ATX_HEADER'][$_position]['value'];

            return $_success;
        }

        $_value59 = array();

        $_position42 = $this->position;
        $_cut43 = $this->cut;

        $this->cut = false;
        $_success = $this->parseATTRIBUTE_START();

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position42;
        $this->cut = $_cut43;

        if ($_success) {
            $_value59[] = $this->value;

            if (substr($this->string, $this->position, strlen('#')) === '#') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('#'));
                $this->position += strlen('#');
            } else {
                $_success = false;

                $this->report($this->position, '\'#\'');
            }

            if ($_success) {
                $_value45 = array($this->value);
                $_cut46 = $this->cut;

                while (true) {
                    $_position44 = $this->position;

                    $this->cut = false;
                    if (substr($this->string, $this->position, strlen('#')) === '#') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen('#'));
                        $this->position += strlen('#');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\'#\'');
                    }

                    if (!$_success) {
                        break;
                    }

                    $_value45[] = $this->value;
                }

                if (!$this->cut) {
                    $_success = true;
                    $this->position = $_position44;
                    $this->value = $_value45;
                }

                $this->cut = $_cut46;
            }
        }

        if ($_success) {
            $_value59[] = $this->value;

            $_position55 = $this->position;

            $_value51 = array();

            $_position49 = $this->position;
            $_cut50 = $this->cut;

            $this->cut = false;
            $_position47 = $this->position;
            $_cut48 = $this->cut;

            $this->cut = false;
            if (substr($this->string, $this->position, strlen('#')) === '#') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('#'));
                $this->position += strlen('#');
            } else {
                $_success = false;

                $this->report($this->position, '\'#\'');
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position47;

                $_success = $this->parseEOL();
            }

            $this->cut = $_cut48;

            if (!$_success) {
                $_success = true;
                $this->value = null;
            } else {
                $_success = false;
            }

            $this->position = $_position49;
            $this->cut = $_cut50;

            if ($_success) {
                $_value51[] = $this->value;

                if ($this->position < strlen($this->string)) {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, 1);
                    $this->position += 1;
                } else {
                    $_success = false;
                }
            }

            if ($_success) {
                $_value51[] = $this->value;

                $this->value = $_value51;
            }

            if ($_success) {
                $_value53 = array($this->value);
                $_cut54 = $this->cut;

                while (true) {
                    $_position52 = $this->position;

                    $this->cut = false;
                    $_value51 = array();

                    $_position49 = $this->position;
                    $_cut50 = $this->cut;

                    $this->cut = false;
                    $_position47 = $this->position;
                    $_cut48 = $this->cut;

                    $this->cut = false;
                    if (substr($this->string, $this->position, strlen('#')) === '#') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen('#'));
                        $this->position += strlen('#');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\'#\'');
                    }

                    if (!$_success && !$this->cut) {
                        $this->position = $_position47;

                        $_success = $this->parseEOL();
                    }

                    $this->cut = $_cut48;

                    if (!$_success) {
                        $_success = true;
                        $this->value = null;
                    } else {
                        $_success = false;
                    }

                    $this->position = $_position49;
                    $this->cut = $_cut50;

                    if ($_success) {
                        $_value51[] = $this->value;

                        if ($this->position < strlen($this->string)) {
                            $_success = true;
                            $this->value = substr($this->string, $this->position, 1);
                            $this->position += 1;
                        } else {
                            $_success = false;
                        }
                    }

                    if ($_success) {
                        $_value51[] = $this->value;

                        $this->value = $_value51;
                    }

                    if (!$_success) {
                        break;
                    }

                    $_value53[] = $this->value;
                }

                if (!$this->cut) {
                    $_success = true;
                    $this->position = $_position52;
                    $this->value = $_value53;
                }

                $this->cut = $_cut54;
            }

            if ($_success) {
                $this->value = strval(substr($this->string, $_position55, $this->position - $_position55));
            }

            if ($_success) {
                $header = $this->value;
            }
        }

        if ($_success) {
            $_value59[] = $this->value;

            $_value57 = array();
            $_cut58 = $this->cut;

            while (true) {
                $_position56 = $this->position;

                $this->cut = false;
                if (substr($this->string, $this->position, strlen('#')) === '#') {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen('#'));
                    $this->position += strlen('#');
                } else {
                    $_success = false;

                    $this->report($this->position, '\'#\'');
                }

                if (!$_success) {
                    break;
                }

                $_value57[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position56;
                $this->value = $_value57;
            }

            $this->cut = $_cut58;
        }

        if ($_success) {
            $_value59[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value59[] = $this->value;

            $this->value = $_value59;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$header) {
                return Name::createAttribute($header);
            });
        }

        $this->cache['ATX_HEADER'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ATX_HEADER');
        }

        return $_success;
    }

    protected function parseSETEXT_HEADER()
    {
        $_position = $this->position;

        if (isset($this->cache['SETEXT_HEADER'][$_position])) {
            $_success = $this->cache['SETEXT_HEADER'][$_position]['success'];
            $this->position = $this->cache['SETEXT_HEADER'][$_position]['position'];
            $this->value = $this->cache['SETEXT_HEADER'][$_position]['value'];

            return $_success;
        }

        $_value75 = array();

        $_position66 = $this->position;

        $_value62 = array();

        $_position60 = $this->position;
        $_cut61 = $this->cut;

        $this->cut = false;
        $_success = $this->parseEOL();

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position60;
        $this->cut = $_cut61;

        if ($_success) {
            $_value62[] = $this->value;

            if ($this->position < strlen($this->string)) {
                $_success = true;
                $this->value = substr($this->string, $this->position, 1);
                $this->position += 1;
            } else {
                $_success = false;
            }
        }

        if ($_success) {
            $_value62[] = $this->value;

            $this->value = $_value62;
        }

        if ($_success) {
            $_value64 = array($this->value);
            $_cut65 = $this->cut;

            while (true) {
                $_position63 = $this->position;

                $this->cut = false;
                $_value62 = array();

                $_position60 = $this->position;
                $_cut61 = $this->cut;

                $this->cut = false;
                $_success = $this->parseEOL();

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position60;
                $this->cut = $_cut61;

                if ($_success) {
                    $_value62[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value62[] = $this->value;

                    $this->value = $_value62;
                }

                if (!$_success) {
                    break;
                }

                $_value64[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position63;
                $this->value = $_value64;
            }

            $this->cut = $_cut65;
        }

        if ($_success) {
            $this->value = strval(substr($this->string, $_position66, $this->position - $_position66));
        }

        if ($_success) {
            $header = $this->value;
        }

        if ($_success) {
            $_value75[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value75[] = $this->value;

            $_position73 = $this->position;
            $_cut74 = $this->cut;

            $this->cut = false;
            if (substr($this->string, $this->position, strlen('=')) === '=') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('='));
                $this->position += strlen('=');
            } else {
                $_success = false;

                $this->report($this->position, '\'=\'');
            }

            if ($_success) {
                $_value68 = array($this->value);
                $_cut69 = $this->cut;

                while (true) {
                    $_position67 = $this->position;

                    $this->cut = false;
                    if (substr($this->string, $this->position, strlen('=')) === '=') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen('='));
                        $this->position += strlen('=');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\'=\'');
                    }

                    if (!$_success) {
                        break;
                    }

                    $_value68[] = $this->value;
                }

                if (!$this->cut) {
                    $_success = true;
                    $this->position = $_position67;
                    $this->value = $_value68;
                }

                $this->cut = $_cut69;
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position73;

                if (substr($this->string, $this->position, strlen('-')) === '-') {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen('-'));
                    $this->position += strlen('-');
                } else {
                    $_success = false;

                    $this->report($this->position, '\'-\'');
                }

                if ($_success) {
                    $_value71 = array($this->value);
                    $_cut72 = $this->cut;

                    while (true) {
                        $_position70 = $this->position;

                        $this->cut = false;
                        if (substr($this->string, $this->position, strlen('-')) === '-') {
                            $_success = true;
                            $this->value = substr($this->string, $this->position, strlen('-'));
                            $this->position += strlen('-');
                        } else {
                            $_success = false;

                            $this->report($this->position, '\'-\'');
                        }

                        if (!$_success) {
                            break;
                        }

                        $_value71[] = $this->value;
                    }

                    if (!$this->cut) {
                        $_success = true;
                        $this->position = $_position70;
                        $this->value = $_value71;
                    }

                    $this->cut = $_cut72;
                }
            }

            $this->cut = $_cut74;
        }

        if ($_success) {
            $_value75[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value75[] = $this->value;

            $this->value = $_value75;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$header) {
                return Name::createAttribute($header);
            });
        }

        $this->cache['SETEXT_HEADER'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'SETEXT_HEADER');
        }

        return $_success;
    }

    protected function parseIGNORED_CONTENT()
    {
        $_position = $this->position;

        if (isset($this->cache['IGNORED_CONTENT'][$_position])) {
            $_success = $this->cache['IGNORED_CONTENT'][$_position]['success'];
            $this->position = $this->cache['IGNORED_CONTENT'][$_position]['position'];
            $this->value = $this->cache['IGNORED_CONTENT'][$_position]['value'];

            return $_success;
        }

        $_value80 = array();

        $_position78 = $this->position;
        $_cut79 = $this->cut;

        $this->cut = false;
        $_position76 = $this->position;
        $_cut77 = $this->cut;

        $this->cut = false;
        $_success = $this->parseATTRIBUTE();

        if (!$_success && !$this->cut) {
            $this->position = $_position76;

            $_success = $this->parseCODE_START();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position76;

            $_success = $this->parseHEADER();
        }

        $this->cut = $_cut77;

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position78;
        $this->cut = $_cut79;

        if ($_success) {
            $_value80[] = $this->value;

            if ($this->position < strlen($this->string)) {
                $_success = true;
                $this->value = substr($this->string, $this->position, 1);
                $this->position += 1;
            } else {
                $_success = false;
            }
        }

        if ($_success) {
            $_value80[] = $this->value;

            $this->value = $_value80;
        }

        if ($_success) {
            $_value82 = array($this->value);
            $_cut83 = $this->cut;

            while (true) {
                $_position81 = $this->position;

                $this->cut = false;
                $_value80 = array();

                $_position78 = $this->position;
                $_cut79 = $this->cut;

                $this->cut = false;
                $_position76 = $this->position;
                $_cut77 = $this->cut;

                $this->cut = false;
                $_success = $this->parseATTRIBUTE();

                if (!$_success && !$this->cut) {
                    $this->position = $_position76;

                    $_success = $this->parseCODE_START();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position76;

                    $_success = $this->parseHEADER();
                }

                $this->cut = $_cut77;

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position78;
                $this->cut = $_cut79;

                if ($_success) {
                    $_value80[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value80[] = $this->value;

                    $this->value = $_value80;
                }

                if (!$_success) {
                    break;
                }

                $_value82[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position81;
                $this->value = $_value82;
            }

            $this->cut = $_cut83;
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return null;
            });
        }

        $this->cache['IGNORED_CONTENT'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'IGNORED_CONTENT');
        }

        return $_success;
    }

    protected function parseCODE()
    {
        $_position = $this->position;

        if (isset($this->cache['CODE'][$_position])) {
            $_success = $this->cache['CODE'][$_position]['success'];
            $this->position = $this->cache['CODE'][$_position]['position'];
            $this->value = $this->cache['CODE'][$_position]['value'];

            return $_success;
        }

        $_value91 = array();

        $_success = $this->parseCODE_START();

        if ($_success) {
            $_value91[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value91[] = $this->value;

            $_position90 = $this->position;

            $_value88 = array();
            $_cut89 = $this->cut;

            while (true) {
                $_position87 = $this->position;

                $this->cut = false;
                $_value86 = array();

                $_position84 = $this->position;
                $_cut85 = $this->cut;

                $this->cut = false;
                $_success = $this->parseCODE_END();

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position84;
                $this->cut = $_cut85;

                if ($_success) {
                    $_value86[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value86[] = $this->value;

                    $this->value = $_value86;
                }

                if (!$_success) {
                    break;
                }

                $_value88[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position87;
                $this->value = $_value88;
            }

            $this->cut = $_cut89;

            if ($_success) {
                $this->value = strval(substr($this->string, $_position90, $this->position - $_position90));
            }

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value91[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value91[] = $this->value;

            $_success = $this->parseCODE_END();
        }

        if ($_success) {
            $_value91[] = $this->value;

            $this->value = $_value91;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$code) {
                return $code;
            });
        }

        $this->cache['CODE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'CODE');
        }

        return $_success;
    }

    protected function parseCODE_START()
    {
        $_position = $this->position;

        if (isset($this->cache['CODE_START'][$_position])) {
            $_success = $this->cache['CODE_START'][$_position]['success'];
            $this->position = $this->cache['CODE_START'][$_position]['position'];
            $this->value = $this->cache['CODE_START'][$_position]['value'];

            return $_success;
        }

        if (strtolower(substr($this->string, $this->position, strlen('```php'))) === strtolower('```php')) {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```php'));
            $this->position += strlen('```php');
        } else {
            $_success = false;

            $this->report($this->position, '\'```php\'');
        }

        $this->cache['CODE_START'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'CODE_START');
        }

        return $_success;
    }

    protected function parseCODE_END()
    {
        $_position = $this->position;

        if (isset($this->cache['CODE_END'][$_position])) {
            $_success = $this->cache['CODE_END'][$_position]['success'];
            $this->position = $this->cache['CODE_END'][$_position]['position'];
            $this->value = $this->cache['CODE_END'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen('```')) === '```') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```'));
            $this->position += strlen('```');
        } else {
            $_success = false;

            $this->report($this->position, '\'```\'');
        }

        $this->cache['CODE_END'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'CODE_END');
        }

        return $_success;
    }

    protected function parse_()
    {
        $_position = $this->position;

        if (isset($this->cache['_'][$_position])) {
            $_success = $this->cache['_'][$_position]['success'];
            $this->position = $this->cache['_'][$_position]['position'];
            $this->value = $this->cache['_'][$_position]['value'];

            return $_success;
        }

        $_value99 = array();

        $_value95 = array();
        $_cut96 = $this->cut;

        while (true) {
            $_position94 = $this->position;

            $this->cut = false;
            $_position92 = $this->position;
            $_cut93 = $this->cut;

            $this->cut = false;
            if (substr($this->string, $this->position, strlen(" ")) === " ") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen(" "));
                $this->position += strlen(" ");
            } else {
                $_success = false;

                $this->report($this->position, '" "');
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position92;

                if (substr($this->string, $this->position, strlen("\t")) === "\t") {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen("\t"));
                    $this->position += strlen("\t");
                } else {
                    $_success = false;

                    $this->report($this->position, '"\\t"');
                }
            }

            $this->cut = $_cut93;

            if (!$_success) {
                break;
            }

            $_value95[] = $this->value;
        }

        if (!$this->cut) {
            $_success = true;
            $this->position = $_position94;
            $this->value = $_value95;
        }

        $this->cut = $_cut96;

        if ($_success) {
            $_value99[] = $this->value;

            $_position97 = $this->position;
            $_cut98 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position97;
                $this->value = null;
            }

            $this->cut = $_cut98;
        }

        if ($_success) {
            $_value99[] = $this->value;

            $this->value = $_value99;
        }

        $this->cache['_'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, "SPACE");
        }

        return $_success;
    }

    protected function parseEOL()
    {
        $_position = $this->position;

        if (isset($this->cache['EOL'][$_position])) {
            $_success = $this->cache['EOL'][$_position]['success'];
            $this->position = $this->cache['EOL'][$_position]['position'];
            $this->value = $this->cache['EOL'][$_position]['value'];

            return $_success;
        }

        $_value102 = array();

        $_position100 = $this->position;
        $_cut101 = $this->cut;

        $this->cut = false;
        if (substr($this->string, $this->position, strlen("\r")) === "\r") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("\r"));
            $this->position += strlen("\r");
        } else {
            $_success = false;

            $this->report($this->position, '"\\r"');
        }

        if (!$_success && !$this->cut) {
            $_success = true;
            $this->position = $_position100;
            $this->value = null;
        }

        $this->cut = $_cut101;

        if ($_success) {
            $_value102[] = $this->value;

            if (substr($this->string, $this->position, strlen("\n")) === "\n") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("\n"));
                $this->position += strlen("\n");
            } else {
                $_success = false;

                $this->report($this->position, '"\\n"');
            }
        }

        if ($_success) {
            $_value102[] = $this->value;

            $this->value = $_value102;
        }

        $this->cache['EOL'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, "END_OF_LINE");
        }

        return $_success;
    }

    private function line()
    {
        if (!empty($this->errors)) {
            $positions = array_keys($this->errors);
        } else {
            $positions = array_keys($this->warnings);
        }

        return count(explode("\n", substr($this->string, 0, max($positions))));
    }

    private function rest()
    {
        return '"' . substr($this->string, $this->position) . '"';
    }

    protected function report($position, $expecting)
    {
        if ($this->cut) {
            $this->errors[$position][] = $expecting;
        } else {
            $this->warnings[$position][] = $expecting;
        }
    }

    private function expecting()
    {
        if (!empty($this->errors)) {
            ksort($this->errors);

            return end($this->errors)[0];
        }

        ksort($this->warnings);

        return implode(', ', end($this->warnings));
    }

    public function parse($_string)
    {
        $this->string = $_string;
        $this->position = 0;
        $this->value = null;
        $this->cache = array();
        $this->cut = false;
        $this->errors = array();
        $this->warnings = array();

        $_success = $this->parseFILE();

        if ($_success && $this->position < strlen($this->string)) {
            $_success = false;

            $this->report($this->position, "end of file");
        }

        if (!$_success) {
            throw new \InvalidArgumentException("Syntax error, expecting {$this->expecting()} on line {$this->line()}");
        }

        return $this->value;
    }
}