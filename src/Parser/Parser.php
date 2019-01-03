<?php

namespace hanneskod\readmetester\Parser;

use hanneskod\readmetester\Utils\CodeBlock;

class Parser
{
    protected $string;
    protected $position;
    protected $value;
    protected $cache;
    protected $cut;
    protected $errors;
    protected $warnings;

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

        $_value4 = array();
        $_cut5 = $this->cut;

        while (true) {
            $_position3 = $this->position;

            $this->cut = false;
            $_position1 = $this->position;
            $_cut2 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEXAMPLE();

            if (!$_success && !$this->cut) {
                $this->position = $_position1;

                $_success = $this->parseVOID_LINE();
            }

            $this->cut = $_cut2;

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
            $this->value = call_user_func(function () use (&$examples) {
                return array_values(array_filter($examples));
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

    protected function parseEXAMPLE()
    {
        $_position = $this->position;

        if (isset($this->cache['EXAMPLE'][$_position])) {
            $_success = $this->cache['EXAMPLE'][$_position]['success'];
            $this->position = $this->cache['EXAMPLE'][$_position]['position'];
            $this->value = $this->cache['EXAMPLE'][$_position]['value'];

            return $_success;
        }

        $_position10 = $this->position;
        $_cut11 = $this->cut;

        $this->cut = false;
        $_success = $this->parseVISIBLE_EXAMPLE();

        if (!$_success && !$this->cut) {
            $this->position = $_position10;

            $_success = $this->parseHIDDEN_EXAMPLE();
        }

        $this->cut = $_cut11;

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

    protected function parseVISIBLE_EXAMPLE()
    {
        $_position = $this->position;

        if (isset($this->cache['VISIBLE_EXAMPLE'][$_position])) {
            $_success = $this->cache['VISIBLE_EXAMPLE'][$_position]['success'];
            $this->position = $this->cache['VISIBLE_EXAMPLE'][$_position]['position'];
            $this->value = $this->cache['VISIBLE_EXAMPLE'][$_position]['value'];

            return $_success;
        }

        $_value17 = array();

        $_position12 = $this->position;
        $_cut13 = $this->cut;

        $this->cut = false;
        $_success = $this->parseANNOTATION_GROUP();

        if (!$_success && !$this->cut) {
            $_success = true;
            $this->position = $_position12;
            $this->value = null;
        }

        $this->cut = $_cut13;

        if ($_success) {
            $annots = $this->value;
        }

        if ($_success) {
            $_value17[] = $this->value;

            $_value15 = array();
            $_cut16 = $this->cut;

            while (true) {
                $_position14 = $this->position;

                $this->cut = false;
                $_success = $this->parseEMPTY_LINE();

                if (!$_success) {
                    break;
                }

                $_value15[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position14;
                $this->value = $_value15;
            }

            $this->cut = $_cut16;
        }

        if ($_success) {
            $_value17[] = $this->value;

            $_success = $this->parseCODE();

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value17[] = $this->value;

            $this->value = $_value17;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$annots, &$code) {
                return new Definition($code, ...(array)$annots);
            });
        }

        $this->cache['VISIBLE_EXAMPLE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'VISIBLE_EXAMPLE');
        }

        return $_success;
    }

    protected function parseHIDDEN_EXAMPLE()
    {
        $_position = $this->position;

        if (isset($this->cache['HIDDEN_EXAMPLE'][$_position])) {
            $_success = $this->cache['HIDDEN_EXAMPLE'][$_position]['success'];
            $this->position = $this->cache['HIDDEN_EXAMPLE'][$_position]['position'];
            $this->value = $this->cache['HIDDEN_EXAMPLE'][$_position]['value'];

            return $_success;
        }

        $_value30 = array();

        $_success = $this->parseHTML_COMMENT_START();

        if ($_success) {
            $_value30[] = $this->value;

            $_value19 = array();
            $_cut20 = $this->cut;

            while (true) {
                $_position18 = $this->position;

                $this->cut = false;
                $_success = $this->parseEMPTY_LINE();

                if (!$_success) {
                    break;
                }

                $_value19[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position18;
                $this->value = $_value19;
            }

            $this->cut = $_cut20;
        }

        if ($_success) {
            $_value30[] = $this->value;

            $_value22 = array();
            $_cut23 = $this->cut;

            while (true) {
                $_position21 = $this->position;

                $this->cut = false;
                $_success = $this->parseANNOTATION();

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

            if ($_success) {
                $annots = $this->value;
            }
        }

        if ($_success) {
            $_value30[] = $this->value;

            $_value25 = array();
            $_cut26 = $this->cut;

            while (true) {
                $_position24 = $this->position;

                $this->cut = false;
                $_success = $this->parseEMPTY_LINE();

                if (!$_success) {
                    break;
                }

                $_value25[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position24;
                $this->value = $_value25;
            }

            $this->cut = $_cut26;
        }

        if ($_success) {
            $_value30[] = $this->value;

            $_success = $this->parseCODE();

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value30[] = $this->value;

            $_value28 = array();
            $_cut29 = $this->cut;

            while (true) {
                $_position27 = $this->position;

                $this->cut = false;
                $_success = $this->parseEMPTY_LINE();

                if (!$_success) {
                    break;
                }

                $_value28[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position27;
                $this->value = $_value28;
            }

            $this->cut = $_cut29;
        }

        if ($_success) {
            $_value30[] = $this->value;

            $_success = $this->parseHTML_COMMENT_END();
        }

        if ($_success) {
            $_value30[] = $this->value;

            $this->value = $_value30;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$annots, &$code) {
                return new Definition($code, ...(array)$annots);
            });
        }

        $this->cache['HIDDEN_EXAMPLE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'HIDDEN_EXAMPLE');
        }

        return $_success;
    }

    protected function parseANNOTATION_GROUP()
    {
        $_position = $this->position;

        if (isset($this->cache['ANNOTATION_GROUP'][$_position])) {
            $_success = $this->cache['ANNOTATION_GROUP'][$_position]['success'];
            $this->position = $this->cache['ANNOTATION_GROUP'][$_position]['position'];
            $this->value = $this->cache['ANNOTATION_GROUP'][$_position]['value'];

            return $_success;
        }

        $_success = $this->parseANNOTATION_BLOCK();

        if ($_success) {
            $_value32 = array($this->value);
            $_cut33 = $this->cut;

            while (true) {
                $_position31 = $this->position;

                $this->cut = false;
                $_success = $this->parseANNOTATION_BLOCK();

                if (!$_success) {
                    break;
                }

                $_value32[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position31;
                $this->value = $_value32;
            }

            $this->cut = $_cut33;
        }

        if ($_success) {
            $blocks = $this->value;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$blocks) {
                return call_user_func_array('array_merge', $blocks);
            });
        }

        $this->cache['ANNOTATION_GROUP'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ANNOTATION_GROUP');
        }

        return $_success;
    }

    protected function parseANNOTATION_BLOCK()
    {
        $_position = $this->position;

        if (isset($this->cache['ANNOTATION_BLOCK'][$_position])) {
            $_success = $this->cache['ANNOTATION_BLOCK'][$_position]['success'];
            $this->position = $this->cache['ANNOTATION_BLOCK'][$_position]['position'];
            $this->value = $this->cache['ANNOTATION_BLOCK'][$_position]['value'];

            return $_success;
        }

        $_value39 = array();

        $_success = $this->parseHTML_COMMENT_START();

        if ($_success) {
            $_value39[] = $this->value;

            $_position34 = $this->position;
            $_cut35 = $this->cut;

            $this->cut = false;
            $_success = $this->parseANNOTATION();

            if (!$_success && !$this->cut) {
                $this->position = $_position34;

                $_success = $this->parseEMPTY_LINE();
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position34;

                $_success = $this->parseVOID_LINE_IN_COMMENT();
            }

            $this->cut = $_cut35;

            if ($_success) {
                $_value37 = array($this->value);
                $_cut38 = $this->cut;

                while (true) {
                    $_position36 = $this->position;

                    $this->cut = false;
                    $_position34 = $this->position;
                    $_cut35 = $this->cut;

                    $this->cut = false;
                    $_success = $this->parseANNOTATION();

                    if (!$_success && !$this->cut) {
                        $this->position = $_position34;

                        $_success = $this->parseEMPTY_LINE();
                    }

                    if (!$_success && !$this->cut) {
                        $this->position = $_position34;

                        $_success = $this->parseVOID_LINE_IN_COMMENT();
                    }

                    $this->cut = $_cut35;

                    if (!$_success) {
                        break;
                    }

                    $_value37[] = $this->value;
                }

                if (!$this->cut) {
                    $_success = true;
                    $this->position = $_position36;
                    $this->value = $_value37;
                }

                $this->cut = $_cut38;
            }

            if ($_success) {
                $annots = $this->value;
            }
        }

        if ($_success) {
            $_value39[] = $this->value;

            $_success = $this->parseHTML_COMMENT_END();
        }

        if ($_success) {
            $_value39[] = $this->value;

            $this->value = $_value39;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$annots) {
                return array_filter($annots);
            });
        }

        $this->cache['ANNOTATION_BLOCK'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ANNOTATION_BLOCK');
        }

        return $_success;
    }

    protected function parseANNOTATION()
    {
        $_position = $this->position;

        if (isset($this->cache['ANNOTATION'][$_position])) {
            $_success = $this->cache['ANNOTATION'][$_position]['success'];
            $this->position = $this->cache['ANNOTATION'][$_position]['position'];
            $this->value = $this->cache['ANNOTATION'][$_position]['value'];

            return $_success;
        }

        $_value45 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value45[] = $this->value;

            if (substr($this->string, $this->position, strlen('@')) === '@') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('@'));
                $this->position += strlen('@');
            } else {
                $_success = false;

                $this->report($this->position, '\'@\'');
            }
        }

        if ($_success) {
            $_value45[] = $this->value;

            $_success = $this->parseSTRING();

            if ($_success) {
                $name = $this->value;
            }
        }

        if ($_success) {
            $_value45[] = $this->value;

            $_value41 = array();
            $_cut42 = $this->cut;

            while (true) {
                $_position40 = $this->position;

                $this->cut = false;
                $_success = $this->parseSTRING();

                if (!$_success) {
                    break;
                }

                $_value41[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position40;
                $this->value = $_value41;
            }

            $this->cut = $_cut42;

            if ($_success) {
                $args = $this->value;
            }
        }

        if ($_success) {
            $_value45[] = $this->value;

            $_position43 = $this->position;
            $_cut44 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position43;
                $this->value = null;
            }

            $this->cut = $_cut44;
        }

        if ($_success) {
            $_value45[] = $this->value;

            $this->value = $_value45;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$name, &$args) {
                return new Annotation($name, ...$args);
            });
        }

        $this->cache['ANNOTATION'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ANNOTATION');
        }

        return $_success;
    }

    protected function parseSTRING()
    {
        $_position = $this->position;

        if (isset($this->cache['STRING'][$_position])) {
            $_success = $this->cache['STRING'][$_position]['success'];
            $this->position = $this->cache['STRING'][$_position]['position'];
            $this->value = $this->cache['STRING'][$_position]['value'];

            return $_success;
        }

        $_value48 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value48[] = $this->value;

            $_position46 = $this->position;
            $_cut47 = $this->cut;

            $this->cut = false;
            $_success = $this->parseRAW_STRING();

            if (!$_success && !$this->cut) {
                $this->position = $_position46;

                $_success = $this->parseDOUBLE_QUOTED_STRING();
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position46;

                $_success = $this->parseSINGLE_QUOTED_STRING();
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position46;

                $_success = $this->parseEMPTY_STRING();
            }

            $this->cut = $_cut47;

            if ($_success) {
                $string = $this->value;
            }
        }

        if ($_success) {
            $_value48[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value48[] = $this->value;

            $this->value = $_value48;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$string) {
                return $string;
            });
        }

        $this->cache['STRING'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'STRING');
        }

        return $_success;
    }

    protected function parseEMPTY_STRING()
    {
        $_position = $this->position;

        if (isset($this->cache['EMPTY_STRING'][$_position])) {
            $_success = $this->cache['EMPTY_STRING'][$_position]['success'];
            $this->position = $this->cache['EMPTY_STRING'][$_position]['position'];
            $this->value = $this->cache['EMPTY_STRING'][$_position]['value'];

            return $_success;
        }

        $_position49 = $this->position;
        $_cut50 = $this->cut;

        $this->cut = false;
        if (substr($this->string, $this->position, strlen('""')) === '""') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('""'));
            $this->position += strlen('""');
        } else {
            $_success = false;

            $this->report($this->position, '\'""\'');
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position49;

            if (substr($this->string, $this->position, strlen("''")) === "''") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("''"));
                $this->position += strlen("''");
            } else {
                $_success = false;

                $this->report($this->position, '"\'\'"');
            }

            if ($_success) {
                $this->value = call_user_func(function () {
                    return '';
                });
            }
        }

        $this->cut = $_cut50;

        $this->cache['EMPTY_STRING'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'EMPTY_STRING');
        }

        return $_success;
    }

    protected function parseDOUBLE_QUOTED_STRING()
    {
        $_position = $this->position;

        if (isset($this->cache['DOUBLE_QUOTED_STRING'][$_position])) {
            $_success = $this->cache['DOUBLE_QUOTED_STRING'][$_position]['success'];
            $this->position = $this->cache['DOUBLE_QUOTED_STRING'][$_position]['position'];
            $this->value = $this->cache['DOUBLE_QUOTED_STRING'][$_position]['value'];

            return $_success;
        }

        $_value56 = array();

        $_success = $this->parseDOUBLE_QUOTE();

        if ($_success) {
            $_value56[] = $this->value;

            $_value54 = array();
            $_cut55 = $this->cut;

            while (true) {
                $_position53 = $this->position;

                $this->cut = false;
                $_position51 = $this->position;
                $_cut52 = $this->cut;

                $this->cut = false;
                $_success = $this->parseESCAPED_DOUBLE_QUOTE();

                if (!$_success && !$this->cut) {
                    $this->position = $_position51;

                    $_success = $this->parseSINGLE_QUOTE();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position51;

                    if (substr($this->string, $this->position, strlen(' ')) === ' ') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen(' '));
                        $this->position += strlen(' ');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\' \'');
                    }
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position51;

                    $_success = $this->parseRAW_STRING();
                }

                $this->cut = $_cut52;

                if (!$_success) {
                    break;
                }

                $_value54[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position53;
                $this->value = $_value54;
            }

            $this->cut = $_cut55;

            if ($_success) {
                $string = $this->value;
            }
        }

        if ($_success) {
            $_value56[] = $this->value;

            $_success = $this->parseDOUBLE_QUOTE();
        }

        if ($_success) {
            $_value56[] = $this->value;

            $this->value = $_value56;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$string) {
                return implode($string);
            });
        }

        $this->cache['DOUBLE_QUOTED_STRING'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'DOUBLE_QUOTED_STRING');
        }

        return $_success;
    }

    protected function parseDOUBLE_QUOTE()
    {
        $_position = $this->position;

        if (isset($this->cache['DOUBLE_QUOTE'][$_position])) {
            $_success = $this->cache['DOUBLE_QUOTE'][$_position]['success'];
            $this->position = $this->cache['DOUBLE_QUOTE'][$_position]['position'];
            $this->value = $this->cache['DOUBLE_QUOTE'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen('"')) === '"') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('"'));
            $this->position += strlen('"');
        } else {
            $_success = false;

            $this->report($this->position, '\'"\'');
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return '"';
            });
        }

        $this->cache['DOUBLE_QUOTE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'DOUBLE_QUOTE');
        }

        return $_success;
    }

    protected function parseESCAPED_DOUBLE_QUOTE()
    {
        $_position = $this->position;

        if (isset($this->cache['ESCAPED_DOUBLE_QUOTE'][$_position])) {
            $_success = $this->cache['ESCAPED_DOUBLE_QUOTE'][$_position]['success'];
            $this->position = $this->cache['ESCAPED_DOUBLE_QUOTE'][$_position]['position'];
            $this->value = $this->cache['ESCAPED_DOUBLE_QUOTE'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen('\"')) === '\"') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('\"'));
            $this->position += strlen('\"');
        } else {
            $_success = false;

            $this->report($this->position, '\'\\"\'');
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return '"';
            });
        }

        $this->cache['ESCAPED_DOUBLE_QUOTE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ESCAPED_DOUBLE_QUOTE');
        }

        return $_success;
    }

    protected function parseSINGLE_QUOTED_STRING()
    {
        $_position = $this->position;

        if (isset($this->cache['SINGLE_QUOTED_STRING'][$_position])) {
            $_success = $this->cache['SINGLE_QUOTED_STRING'][$_position]['success'];
            $this->position = $this->cache['SINGLE_QUOTED_STRING'][$_position]['position'];
            $this->value = $this->cache['SINGLE_QUOTED_STRING'][$_position]['value'];

            return $_success;
        }

        $_value62 = array();

        $_success = $this->parseSINGLE_QUOTE();

        if ($_success) {
            $_value62[] = $this->value;

            $_value60 = array();
            $_cut61 = $this->cut;

            while (true) {
                $_position59 = $this->position;

                $this->cut = false;
                $_position57 = $this->position;
                $_cut58 = $this->cut;

                $this->cut = false;
                $_success = $this->parseESCAPED_SINGLE_QUOTE();

                if (!$_success && !$this->cut) {
                    $this->position = $_position57;

                    $_success = $this->parseDOUBLE_QUOTE();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position57;

                    if (substr($this->string, $this->position, strlen(' ')) === ' ') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen(' '));
                        $this->position += strlen(' ');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\' \'');
                    }
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position57;

                    $_success = $this->parseRAW_STRING();
                }

                $this->cut = $_cut58;

                if (!$_success) {
                    break;
                }

                $_value60[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position59;
                $this->value = $_value60;
            }

            $this->cut = $_cut61;

            if ($_success) {
                $string = $this->value;
            }
        }

        if ($_success) {
            $_value62[] = $this->value;

            $_success = $this->parseSINGLE_QUOTE();
        }

        if ($_success) {
            $_value62[] = $this->value;

            $this->value = $_value62;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$string) {
                return implode($string);
            });
        }

        $this->cache['SINGLE_QUOTED_STRING'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'SINGLE_QUOTED_STRING');
        }

        return $_success;
    }

    protected function parseSINGLE_QUOTE()
    {
        $_position = $this->position;

        if (isset($this->cache['SINGLE_QUOTE'][$_position])) {
            $_success = $this->cache['SINGLE_QUOTE'][$_position]['success'];
            $this->position = $this->cache['SINGLE_QUOTE'][$_position]['position'];
            $this->value = $this->cache['SINGLE_QUOTE'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen("'")) === "'") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("'"));
            $this->position += strlen("'");
        } else {
            $_success = false;

            $this->report($this->position, '"\'"');
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return "'";
            });
        }

        $this->cache['SINGLE_QUOTE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'SINGLE_QUOTE');
        }

        return $_success;
    }

    protected function parseESCAPED_SINGLE_QUOTE()
    {
        $_position = $this->position;

        if (isset($this->cache['ESCAPED_SINGLE_QUOTE'][$_position])) {
            $_success = $this->cache['ESCAPED_SINGLE_QUOTE'][$_position]['success'];
            $this->position = $this->cache['ESCAPED_SINGLE_QUOTE'][$_position]['position'];
            $this->value = $this->cache['ESCAPED_SINGLE_QUOTE'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen("\'")) === "\'") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("\'"));
            $this->position += strlen("\'");
        } else {
            $_success = false;

            $this->report($this->position, '"\\\'"');
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return "'";
            });
        }

        $this->cache['ESCAPED_SINGLE_QUOTE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ESCAPED_SINGLE_QUOTE');
        }

        return $_success;
    }

    protected function parseRAW_STRING()
    {
        $_position = $this->position;

        if (isset($this->cache['RAW_STRING'][$_position])) {
            $_success = $this->cache['RAW_STRING'][$_position]['success'];
            $this->position = $this->cache['RAW_STRING'][$_position]['position'];
            $this->value = $this->cache['RAW_STRING'][$_position]['value'];

            return $_success;
        }

        $_position71 = $this->position;

        $_value67 = array();

        $_position65 = $this->position;
        $_cut66 = $this->cut;

        $this->cut = false;
        $_position63 = $this->position;
        $_cut64 = $this->cut;

        $this->cut = false;
        if (substr($this->string, $this->position, strlen(' ')) === ' ') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen(' '));
            $this->position += strlen(' ');
        } else {
            $_success = false;

            $this->report($this->position, '\' \'');
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position63;

            if (substr($this->string, $this->position, strlen("\r")) === "\r") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("\r"));
                $this->position += strlen("\r");
            } else {
                $_success = false;

                $this->report($this->position, '"\\r"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position63;

            if (substr($this->string, $this->position, strlen("\n")) === "\n") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("\n"));
                $this->position += strlen("\n");
            } else {
                $_success = false;

                $this->report($this->position, '"\\n"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position63;

            if (substr($this->string, $this->position, strlen("\t")) === "\t") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("\t"));
                $this->position += strlen("\t");
            } else {
                $_success = false;

                $this->report($this->position, '"\\t"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position63;

            $_success = $this->parseCOMMENT_END();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position63;

            $_success = $this->parseCOMMENT_END_COLD_FUSION();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position63;

            $_success = $this->parseDOUBLE_QUOTE();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position63;

            $_success = $this->parseSINGLE_QUOTE();
        }

        $this->cut = $_cut64;

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position65;
        $this->cut = $_cut66;

        if ($_success) {
            $_value67[] = $this->value;

            if ($this->position < strlen($this->string)) {
                $_success = true;
                $this->value = substr($this->string, $this->position, 1);
                $this->position += 1;
            } else {
                $_success = false;
            }
        }

        if ($_success) {
            $_value67[] = $this->value;

            $this->value = $_value67;
        }

        if ($_success) {
            $_value69 = array($this->value);
            $_cut70 = $this->cut;

            while (true) {
                $_position68 = $this->position;

                $this->cut = false;
                $_value67 = array();

                $_position65 = $this->position;
                $_cut66 = $this->cut;

                $this->cut = false;
                $_position63 = $this->position;
                $_cut64 = $this->cut;

                $this->cut = false;
                if (substr($this->string, $this->position, strlen(' ')) === ' ') {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen(' '));
                    $this->position += strlen(' ');
                } else {
                    $_success = false;

                    $this->report($this->position, '\' \'');
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position63;

                    if (substr($this->string, $this->position, strlen("\r")) === "\r") {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen("\r"));
                        $this->position += strlen("\r");
                    } else {
                        $_success = false;

                        $this->report($this->position, '"\\r"');
                    }
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position63;

                    if (substr($this->string, $this->position, strlen("\n")) === "\n") {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen("\n"));
                        $this->position += strlen("\n");
                    } else {
                        $_success = false;

                        $this->report($this->position, '"\\n"');
                    }
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position63;

                    if (substr($this->string, $this->position, strlen("\t")) === "\t") {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen("\t"));
                        $this->position += strlen("\t");
                    } else {
                        $_success = false;

                        $this->report($this->position, '"\\t"');
                    }
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position63;

                    $_success = $this->parseCOMMENT_END();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position63;

                    $_success = $this->parseCOMMENT_END_COLD_FUSION();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position63;

                    $_success = $this->parseDOUBLE_QUOTE();
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position63;

                    $_success = $this->parseSINGLE_QUOTE();
                }

                $this->cut = $_cut64;

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position65;
                $this->cut = $_cut66;

                if ($_success) {
                    $_value67[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value67[] = $this->value;

                    $this->value = $_value67;
                }

                if (!$_success) {
                    break;
                }

                $_value69[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position68;
                $this->value = $_value69;
            }

            $this->cut = $_cut70;
        }

        if ($_success) {
            $this->value = strval(substr($this->string, $_position71, $this->position - $_position71));
        }

        $this->cache['RAW_STRING'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'RAW_STRING');
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

        $_value79 = array();

        $_success = $this->parseCODE_START();

        if ($_success) {
            $_value79[] = $this->value;

            $_position78 = $this->position;

            $_value76 = array();
            $_cut77 = $this->cut;

            while (true) {
                $_position75 = $this->position;

                $this->cut = false;
                $_value74 = array();

                $_position72 = $this->position;
                $_cut73 = $this->cut;

                $this->cut = false;
                $_success = $this->parseCODE_END();

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position72;
                $this->cut = $_cut73;

                if ($_success) {
                    $_value74[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value74[] = $this->value;

                    $this->value = $_value74;
                }

                if (!$_success) {
                    break;
                }

                $_value76[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position75;
                $this->value = $_value76;
            }

            $this->cut = $_cut77;

            if ($_success) {
                $this->value = strval(substr($this->string, $_position78, $this->position - $_position78));
            }

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value79[] = $this->value;

            $_success = $this->parseCODE_END();
        }

        if ($_success) {
            $_value79[] = $this->value;

            $this->value = $_value79;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$code) {
                return new CodeBlock($code);
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

        $_value80 = array();

        if (strtolower(substr($this->string, $this->position, strlen('```php'))) === strtolower('```php')) {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```php'));
            $this->position += strlen('```php');
        } else {
            $_success = false;

            $this->report($this->position, '\'```php\'');
        }

        if ($_success) {
            $_value80[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value80[] = $this->value;

            $this->value = $_value80;
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

        $_value83 = array();

        if (substr($this->string, $this->position, strlen('```')) === '```') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```'));
            $this->position += strlen('```');
        } else {
            $_success = false;

            $this->report($this->position, '\'```\'');
        }

        if ($_success) {
            $_value83[] = $this->value;

            $_position81 = $this->position;
            $_cut82 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $this->position = $_position81;

                $_success = $this->parseEOF();
            }

            $this->cut = $_cut82;
        }

        if ($_success) {
            $_value83[] = $this->value;

            $this->value = $_value83;
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

    protected function parseVOID_LINE_IN_COMMENT()
    {
        $_position = $this->position;

        if (isset($this->cache['VOID_LINE_IN_COMMENT'][$_position])) {
            $_success = $this->cache['VOID_LINE_IN_COMMENT'][$_position]['success'];
            $this->position = $this->cache['VOID_LINE_IN_COMMENT'][$_position]['position'];
            $this->value = $this->cache['VOID_LINE_IN_COMMENT'][$_position]['value'];

            return $_success;
        }

        $_value86 = array();

        $_position84 = $this->position;
        $_cut85 = $this->cut;

        $this->cut = false;
        $_success = $this->parseHTML_COMMENT_END();

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

            $_success = $this->parseVOID_LINE();
        }

        if ($_success) {
            $_value86[] = $this->value;

            $this->value = $_value86;
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                
            });
        }

        $this->cache['VOID_LINE_IN_COMMENT'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'VOID_LINE_IN_COMMENT');
        }

        return $_success;
    }

    protected function parseVOID_LINE()
    {
        $_position = $this->position;

        if (isset($this->cache['VOID_LINE'][$_position])) {
            $_success = $this->cache['VOID_LINE'][$_position]['success'];
            $this->position = $this->cache['VOID_LINE'][$_position]['position'];
            $this->value = $this->cache['VOID_LINE'][$_position]['value'];

            return $_success;
        }

        $_value93 = array();

        $_value91 = array();
        $_cut92 = $this->cut;

        while (true) {
            $_position90 = $this->position;

            $this->cut = false;
            $_value89 = array();

            $_position87 = $this->position;
            $_cut88 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success) {
                $_success = true;
                $this->value = null;
            } else {
                $_success = false;
            }

            $this->position = $_position87;
            $this->cut = $_cut88;

            if ($_success) {
                $_value89[] = $this->value;

                if ($this->position < strlen($this->string)) {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, 1);
                    $this->position += 1;
                } else {
                    $_success = false;
                }
            }

            if ($_success) {
                $_value89[] = $this->value;

                $this->value = $_value89;
            }

            if (!$_success) {
                break;
            }

            $_value91[] = $this->value;
        }

        if (!$this->cut) {
            $_success = true;
            $this->position = $_position90;
            $this->value = $_value91;
        }

        $this->cut = $_cut92;

        if ($_success) {
            $_value93[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value93[] = $this->value;

            $this->value = $_value93;
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                
            });
        }

        $this->cache['VOID_LINE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'VOID_LINE');
        }

        return $_success;
    }

    protected function parseEMPTY_LINE()
    {
        $_position = $this->position;

        if (isset($this->cache['EMPTY_LINE'][$_position])) {
            $_success = $this->cache['EMPTY_LINE'][$_position]['success'];
            $this->position = $this->cache['EMPTY_LINE'][$_position]['position'];
            $this->value = $this->cache['EMPTY_LINE'][$_position]['value'];

            return $_success;
        }

        $_value94 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value94[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value94[] = $this->value;

            $this->value = $_value94;
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                
            });
        }

        $this->cache['EMPTY_LINE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'EMPTY_LINE');
        }

        return $_success;
    }

    protected function parseHTML_COMMENT_START()
    {
        $_position = $this->position;

        if (isset($this->cache['HTML_COMMENT_START'][$_position])) {
            $_success = $this->cache['HTML_COMMENT_START'][$_position]['success'];
            $this->position = $this->cache['HTML_COMMENT_START'][$_position]['position'];
            $this->value = $this->cache['HTML_COMMENT_START'][$_position]['value'];

            return $_success;
        }

        $_value99 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value99[] = $this->value;

            if (substr($this->string, $this->position, strlen('<!--')) === '<!--') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('<!--'));
                $this->position += strlen('<!--');
            } else {
                $_success = false;

                $this->report($this->position, '\'<!--\'');
            }
        }

        if ($_success) {
            $_value99[] = $this->value;

            $_position95 = $this->position;
            $_cut96 = $this->cut;

            $this->cut = false;
            if (substr($this->string, $this->position, strlen('-')) === '-') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('-'));
                $this->position += strlen('-');
            } else {
                $_success = false;

                $this->report($this->position, '\'-\'');
            }

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position95;
                $this->value = null;
            }

            $this->cut = $_cut96;
        }

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

        $this->cache['HTML_COMMENT_START'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'HTML_COMMENT_START');
        }

        return $_success;
    }

    protected function parseHTML_COMMENT_END()
    {
        $_position = $this->position;

        if (isset($this->cache['HTML_COMMENT_END'][$_position])) {
            $_success = $this->cache['HTML_COMMENT_END'][$_position]['success'];
            $this->position = $this->cache['HTML_COMMENT_END'][$_position]['position'];
            $this->value = $this->cache['HTML_COMMENT_END'][$_position]['value'];

            return $_success;
        }

        $_value104 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value104[] = $this->value;

            $_position100 = $this->position;
            $_cut101 = $this->cut;

            $this->cut = false;
            $_success = $this->parseCOMMENT_END();

            if (!$_success && !$this->cut) {
                $this->position = $_position100;

                $_success = $this->parseCOMMENT_END_COLD_FUSION();
            }

            $this->cut = $_cut101;
        }

        if ($_success) {
            $_value104[] = $this->value;

            $_position102 = $this->position;
            $_cut103 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position102;
                $this->value = null;
            }

            $this->cut = $_cut103;
        }

        if ($_success) {
            $_value104[] = $this->value;

            $this->value = $_value104;
        }

        $this->cache['HTML_COMMENT_END'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'HTML_COMMENT_END');
        }

        return $_success;
    }

    protected function parseCOMMENT_END()
    {
        $_position = $this->position;

        if (isset($this->cache['COMMENT_END'][$_position])) {
            $_success = $this->cache['COMMENT_END'][$_position]['success'];
            $this->position = $this->cache['COMMENT_END'][$_position]['position'];
            $this->value = $this->cache['COMMENT_END'][$_position]['value'];

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

        $this->cache['COMMENT_END'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, "-->");
        }

        return $_success;
    }

    protected function parseCOMMENT_END_COLD_FUSION()
    {
        $_position = $this->position;

        if (isset($this->cache['COMMENT_END_COLD_FUSION'][$_position])) {
            $_success = $this->cache['COMMENT_END_COLD_FUSION'][$_position]['success'];
            $this->position = $this->cache['COMMENT_END_COLD_FUSION'][$_position]['position'];
            $this->value = $this->cache['COMMENT_END_COLD_FUSION'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen('--->')) === '--->') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('--->'));
            $this->position += strlen('--->');
        } else {
            $_success = false;

            $this->report($this->position, '\'--->\'');
        }

        $this->cache['COMMENT_END_COLD_FUSION'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, "--->");
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

        $_value107 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value107[] = $this->value;

            $_position105 = $this->position;
            $_cut106 = $this->cut;

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
                $this->position = $_position105;
                $this->value = null;
            }

            $this->cut = $_cut106;
        }

        if ($_success) {
            $_value107[] = $this->value;

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
            $_value107[] = $this->value;

            $this->value = $_value107;
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

    protected function parseEOF()
    {
        $_position = $this->position;

        if (isset($this->cache['EOF'][$_position])) {
            $_success = $this->cache['EOF'][$_position]['success'];
            $this->position = $this->cache['EOF'][$_position]['position'];
            $this->value = $this->cache['EOF'][$_position]['value'];

            return $_success;
        }

        $_position108 = $this->position;
        $_cut109 = $this->cut;

        $this->cut = false;
        if ($this->position < strlen($this->string)) {
            $_success = true;
            $this->value = substr($this->string, $this->position, 1);
            $this->position += 1;
        } else {
            $_success = false;
        }

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position108;
        $this->cut = $_cut109;

        $this->cache['EOF'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, "END_OF_FILE");
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

        $_value113 = array();
        $_cut114 = $this->cut;

        while (true) {
            $_position112 = $this->position;

            $this->cut = false;
            $_position110 = $this->position;
            $_cut111 = $this->cut;

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
                $this->position = $_position110;

                if (substr($this->string, $this->position, strlen("\t")) === "\t") {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen("\t"));
                    $this->position += strlen("\t");
                } else {
                    $_success = false;

                    $this->report($this->position, '"\\t"');
                }
            }

            $this->cut = $_cut111;

            if (!$_success) {
                break;
            }

            $_value113[] = $this->value;
        }

        if (!$this->cut) {
            $_success = true;
            $this->position = $_position112;
            $this->value = $_value113;
        }

        $this->cut = $_cut114;

        $this->cache['_'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, '_');
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