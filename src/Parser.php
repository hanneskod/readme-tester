<?php

namespace hanneskod\readmetester;

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

    protected function parseVOID_LINE()
    {
        $_position = $this->position;

        if (isset($this->cache['VOID_LINE'][$_position])) {
            $_success = $this->cache['VOID_LINE'][$_position]['success'];
            $this->position = $this->cache['VOID_LINE'][$_position]['position'];
            $this->value = $this->cache['VOID_LINE'][$_position]['value'];

            return $_success;
        }

        $_value16 = array();

        $_value14 = array();
        $_cut15 = $this->cut;

        while (true) {
            $_position13 = $this->position;

            $this->cut = false;
            $_value12 = array();

            $_position10 = $this->position;
            $_cut11 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success) {
                $_success = true;
                $this->value = null;
            } else {
                $_success = false;
            }

            $this->position = $_position10;
            $this->cut = $_cut11;

            if ($_success) {
                $_value12[] = $this->value;

                if ($this->position < strlen($this->string)) {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, 1);
                    $this->position += 1;
                } else {
                    $_success = false;
                }
            }

            if ($_success) {
                $_value12[] = $this->value;

                $this->value = $_value12;
            }

            if (!$_success) {
                break;
            }

            $_value14[] = $this->value;
        }

        if (!$this->cut) {
            $_success = true;
            $this->position = $_position13;
            $this->value = $_value14;
        }

        $this->cut = $_cut15;

        if ($_success) {
            $_value16[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value16[] = $this->value;

            $this->value = $_value16;
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return '';
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

        $_value17 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value17[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value17[] = $this->value;

            $this->value = $_value17;
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

    protected function parseEXAMPLE()
    {
        $_position = $this->position;

        if (isset($this->cache['EXAMPLE'][$_position])) {
            $_success = $this->cache['EXAMPLE'][$_position]['success'];
            $this->position = $this->cache['EXAMPLE'][$_position]['position'];
            $this->value = $this->cache['EXAMPLE'][$_position]['value'];

            return $_success;
        }

        $_position18 = $this->position;
        $_cut19 = $this->cut;

        $this->cut = false;
        $_success = $this->parseVISIBLE_EXAMPLE();

        if (!$_success && !$this->cut) {
            $this->position = $_position18;

            $_success = $this->parseHIDDEN_EXAMPLE();
        }

        $this->cut = $_cut19;

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

        $_value22 = array();

        $_position20 = $this->position;
        $_cut21 = $this->cut;

        $this->cut = false;
        $_success = $this->parseANNOTATIONS();

        if (!$_success && !$this->cut) {
            $_success = true;
            $this->position = $_position20;
            $this->value = null;
        }

        $this->cut = $_cut21;

        if ($_success) {
            $annotations = $this->value;
        }

        if ($_success) {
            $_value22[] = $this->value;

            $_success = $this->parseCODE();

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value22[] = $this->value;

            $this->value = $_value22;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$annotations, &$code) {
                return new Definition($code, ...(array)$annotations);
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

        $_value35 = array();

        $_success = $this->parseHTML_COMMENT_START();

        if ($_success) {
            $_value35[] = $this->value;

            $_value24 = array();
            $_cut25 = $this->cut;

            while (true) {
                $_position23 = $this->position;

                $this->cut = false;
                $_success = $this->parseEMPTY_LINE();

                if (!$_success) {
                    break;
                }

                $_value24[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position23;
                $this->value = $_value24;
            }

            $this->cut = $_cut25;
        }

        if ($_success) {
            $_value35[] = $this->value;

            $_value27 = array();
            $_cut28 = $this->cut;

            while (true) {
                $_position26 = $this->position;

                $this->cut = false;
                $_success = $this->parseANNOTATION();

                if (!$_success) {
                    break;
                }

                $_value27[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position26;
                $this->value = $_value27;
            }

            $this->cut = $_cut28;

            if ($_success) {
                $annotations = $this->value;
            }
        }

        if ($_success) {
            $_value35[] = $this->value;

            $_value30 = array();
            $_cut31 = $this->cut;

            while (true) {
                $_position29 = $this->position;

                $this->cut = false;
                $_success = $this->parseEMPTY_LINE();

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
            $_value35[] = $this->value;

            $_success = $this->parseCODE();

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value35[] = $this->value;

            $_value33 = array();
            $_cut34 = $this->cut;

            while (true) {
                $_position32 = $this->position;

                $this->cut = false;
                $_success = $this->parseEMPTY_LINE();

                if (!$_success) {
                    break;
                }

                $_value33[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position32;
                $this->value = $_value33;
            }

            $this->cut = $_cut34;
        }

        if ($_success) {
            $_value35[] = $this->value;

            $_success = $this->parseHTML_COMMENT_END();
        }

        if ($_success) {
            $_value35[] = $this->value;

            $this->value = $_value35;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$annotations, &$code) {
                return new Definition($code, ...(array)$annotations);
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

    protected function parseANNOTATIONS()
    {
        $_position = $this->position;

        if (isset($this->cache['ANNOTATIONS'][$_position])) {
            $_success = $this->cache['ANNOTATIONS'][$_position]['success'];
            $this->position = $this->cache['ANNOTATIONS'][$_position]['position'];
            $this->value = $this->cache['ANNOTATIONS'][$_position]['value'];

            return $_success;
        }

        $_success = $this->parseANNOTATION_GROUP();

        if ($_success) {
            $_value37 = array($this->value);
            $_cut38 = $this->cut;

            while (true) {
                $_position36 = $this->position;

                $this->cut = false;
                $_success = $this->parseANNOTATION_GROUP();

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
            $groups = $this->value;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$groups) {
                return call_user_func_array('array_merge', $groups);
            });
        }

        $this->cache['ANNOTATIONS'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ANNOTATIONS');
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

        $_value42 = array();

        $_success = $this->parseHTML_COMMENT_START();

        if ($_success) {
            $_value42[] = $this->value;

            $_success = $this->parseANNOTATION();

            if ($_success) {
                $_value40 = array($this->value);
                $_cut41 = $this->cut;

                while (true) {
                    $_position39 = $this->position;

                    $this->cut = false;
                    $_success = $this->parseANNOTATION();

                    if (!$_success) {
                        break;
                    }

                    $_value40[] = $this->value;
                }

                if (!$this->cut) {
                    $_success = true;
                    $this->position = $_position39;
                    $this->value = $_value40;
                }

                $this->cut = $_cut41;
            }

            if ($_success) {
                $annotations = $this->value;
            }
        }

        if ($_success) {
            $_value42[] = $this->value;

            $_success = $this->parseHTML_COMMENT_END();
        }

        if ($_success) {
            $_value42[] = $this->value;

            $this->value = $_value42;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$annotations) {
                return $annotations;
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

    protected function parseHTML_COMMENT_START()
    {
        $_position = $this->position;

        if (isset($this->cache['HTML_COMMENT_START'][$_position])) {
            $_success = $this->cache['HTML_COMMENT_START'][$_position]['success'];
            $this->position = $this->cache['HTML_COMMENT_START'][$_position]['position'];
            $this->value = $this->cache['HTML_COMMENT_START'][$_position]['value'];

            return $_success;
        }

        $_value47 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value47[] = $this->value;

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
            $_value47[] = $this->value;

            $_position43 = $this->position;
            $_cut44 = $this->cut;

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
                $this->position = $_position43;
                $this->value = null;
            }

            $this->cut = $_cut44;
        }

        if ($_success) {
            $_value47[] = $this->value;

            $_position45 = $this->position;
            $_cut46 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position45;
                $this->value = null;
            }

            $this->cut = $_cut46;
        }

        if ($_success) {
            $_value47[] = $this->value;

            $this->value = $_value47;
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

        $_value50 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value50[] = $this->value;

            if (substr($this->string, $this->position, strlen('-->')) === '-->') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('-->'));
                $this->position += strlen('-->');
            } else {
                $_success = false;

                $this->report($this->position, '\'-->\'');
            }
        }

        if ($_success) {
            $_value50[] = $this->value;

            $_position48 = $this->position;
            $_cut49 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position48;
                $this->value = null;
            }

            $this->cut = $_cut49;
        }

        if ($_success) {
            $_value50[] = $this->value;

            $this->value = $_value50;
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

    protected function parseANNOTATION()
    {
        $_position = $this->position;

        if (isset($this->cache['ANNOTATION'][$_position])) {
            $_success = $this->cache['ANNOTATION'][$_position]['success'];
            $this->position = $this->cache['ANNOTATION'][$_position]['position'];
            $this->value = $this->cache['ANNOTATION'][$_position]['value'];

            return $_success;
        }

        $_value56 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value56[] = $this->value;

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
            $_value56[] = $this->value;

            $_success = $this->parseSTRING();

            if ($_success) {
                $name = $this->value;
            }
        }

        if ($_success) {
            $_value56[] = $this->value;

            $_value52 = array();
            $_cut53 = $this->cut;

            while (true) {
                $_position51 = $this->position;

                $this->cut = false;
                $_success = $this->parseSTRING();

                if (!$_success) {
                    break;
                }

                $_value52[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position51;
                $this->value = $_value52;
            }

            $this->cut = $_cut53;

            if ($_success) {
                $args = $this->value;
            }
        }

        if ($_success) {
            $_value56[] = $this->value;

            $_position54 = $this->position;
            $_cut55 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position54;
                $this->value = null;
            }

            $this->cut = $_cut55;
        }

        if ($_success) {
            $_value56[] = $this->value;

            $this->value = $_value56;
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

        $_value59 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value59[] = $this->value;

            $_position57 = $this->position;
            $_cut58 = $this->cut;

            $this->cut = false;
            $_success = $this->parseRAW_STRING();

            if (!$_success && !$this->cut) {
                $this->position = $_position57;

                $_success = $this->parseQUOTED_STRING();
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position57;

                $_success = $this->parseEMPTY_STRING();
            }

            $this->cut = $_cut58;

            if ($_success) {
                $string = $this->value;
            }
        }

        if ($_success) {
            $_value59[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value59[] = $this->value;

            $this->value = $_value59;
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

        if (substr($this->string, $this->position, strlen('""')) === '""') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('""'));
            $this->position += strlen('""');
        } else {
            $_success = false;

            $this->report($this->position, '\'""\'');
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return '';
            });
        }

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

    protected function parseQUOTED_STRING()
    {
        $_position = $this->position;

        if (isset($this->cache['QUOTED_STRING'][$_position])) {
            $_success = $this->cache['QUOTED_STRING'][$_position]['success'];
            $this->position = $this->cache['QUOTED_STRING'][$_position]['position'];
            $this->value = $this->cache['QUOTED_STRING'][$_position]['value'];

            return $_success;
        }

        $_value65 = array();

        if (substr($this->string, $this->position, strlen('"')) === '"') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('"'));
            $this->position += strlen('"');
        } else {
            $_success = false;

            $this->report($this->position, '\'"\'');
        }

        if ($_success) {
            $_value65[] = $this->value;

            $_value63 = array();
            $_cut64 = $this->cut;

            while (true) {
                $_position62 = $this->position;

                $this->cut = false;
                $_position60 = $this->position;
                $_cut61 = $this->cut;

                $this->cut = false;
                $_success = $this->parseESCAPED_QUOTE();

                if (!$_success && !$this->cut) {
                    $this->position = $_position60;

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
                    $this->position = $_position60;

                    $_success = $this->parseRAW_STRING();
                }

                $this->cut = $_cut61;

                if (!$_success) {
                    break;
                }

                $_value63[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position62;
                $this->value = $_value63;
            }

            $this->cut = $_cut64;

            if ($_success) {
                $string = $this->value;
            }
        }

        if ($_success) {
            $_value65[] = $this->value;

            if (substr($this->string, $this->position, strlen('"')) === '"') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('"'));
                $this->position += strlen('"');
            } else {
                $_success = false;

                $this->report($this->position, '\'"\'');
            }
        }

        if ($_success) {
            $_value65[] = $this->value;

            $this->value = $_value65;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$string) {
                return implode($string);
            });
        }

        $this->cache['QUOTED_STRING'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'QUOTED_STRING');
        }

        return $_success;
    }

    protected function parseESCAPED_QUOTE()
    {
        $_position = $this->position;

        if (isset($this->cache['ESCAPED_QUOTE'][$_position])) {
            $_success = $this->cache['ESCAPED_QUOTE'][$_position]['success'];
            $this->position = $this->cache['ESCAPED_QUOTE'][$_position]['position'];
            $this->value = $this->cache['ESCAPED_QUOTE'][$_position]['value'];

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

        $this->cache['ESCAPED_QUOTE'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ESCAPED_QUOTE');
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

        $_position74 = $this->position;

        $_value70 = array();

        $_position68 = $this->position;
        $_cut69 = $this->cut;

        $this->cut = false;
        $_position66 = $this->position;
        $_cut67 = $this->cut;

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
            $this->position = $_position66;

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
            $this->position = $_position66;

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
            $this->position = $_position66;

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
            $this->position = $_position66;

            if (substr($this->string, $this->position, strlen('-->')) === '-->') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('-->'));
                $this->position += strlen('-->');
            } else {
                $_success = false;

                $this->report($this->position, '\'-->\'');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position66;

            if (substr($this->string, $this->position, strlen('"')) === '"') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('"'));
                $this->position += strlen('"');
            } else {
                $_success = false;

                $this->report($this->position, '\'"\'');
            }
        }

        $this->cut = $_cut67;

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position68;
        $this->cut = $_cut69;

        if ($_success) {
            $_value70[] = $this->value;

            if ($this->position < strlen($this->string)) {
                $_success = true;
                $this->value = substr($this->string, $this->position, 1);
                $this->position += 1;
            } else {
                $_success = false;
            }
        }

        if ($_success) {
            $_value70[] = $this->value;

            $this->value = $_value70;
        }

        if ($_success) {
            $_value72 = array($this->value);
            $_cut73 = $this->cut;

            while (true) {
                $_position71 = $this->position;

                $this->cut = false;
                $_value70 = array();

                $_position68 = $this->position;
                $_cut69 = $this->cut;

                $this->cut = false;
                $_position66 = $this->position;
                $_cut67 = $this->cut;

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
                    $this->position = $_position66;

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
                    $this->position = $_position66;

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
                    $this->position = $_position66;

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
                    $this->position = $_position66;

                    if (substr($this->string, $this->position, strlen('-->')) === '-->') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen('-->'));
                        $this->position += strlen('-->');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\'-->\'');
                    }
                }

                if (!$_success && !$this->cut) {
                    $this->position = $_position66;

                    if (substr($this->string, $this->position, strlen('"')) === '"') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen('"'));
                        $this->position += strlen('"');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\'"\'');
                    }
                }

                $this->cut = $_cut67;

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position68;
                $this->cut = $_cut69;

                if ($_success) {
                    $_value70[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value70[] = $this->value;

                    $this->value = $_value70;
                }

                if (!$_success) {
                    break;
                }

                $_value72[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position71;
                $this->value = $_value72;
            }

            $this->cut = $_cut73;
        }

        if ($_success) {
            $this->value = strval(substr($this->string, $_position74, $this->position - $_position74));
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

        $_value82 = array();

        $_success = $this->parseCODE_START();

        if ($_success) {
            $_value82[] = $this->value;

            $_position81 = $this->position;

            $_value79 = array();
            $_cut80 = $this->cut;

            while (true) {
                $_position78 = $this->position;

                $this->cut = false;
                $_value77 = array();

                $_position75 = $this->position;
                $_cut76 = $this->cut;

                $this->cut = false;
                $_success = $this->parseCODE_END();

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position75;
                $this->cut = $_cut76;

                if ($_success) {
                    $_value77[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value77[] = $this->value;

                    $this->value = $_value77;
                }

                if (!$_success) {
                    break;
                }

                $_value79[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position78;
                $this->value = $_value79;
            }

            $this->cut = $_cut80;

            if ($_success) {
                $this->value = strval(substr($this->string, $_position81, $this->position - $_position81));
            }

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value82[] = $this->value;

            $_success = $this->parseCODE_END();
        }

        if ($_success) {
            $_value82[] = $this->value;

            $this->value = $_value82;
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

        $_value83 = array();

        if (strtolower(substr($this->string, $this->position, strlen('```php'))) === strtolower('```php')) {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```php'));
            $this->position += strlen('```php');
        } else {
            $_success = false;

            $this->report($this->position, '\'```php\'');
        }

        if ($_success) {
            $_value83[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value83[] = $this->value;

            $this->value = $_value83;
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

        $_value86 = array();

        if (substr($this->string, $this->position, strlen('```')) === '```') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```'));
            $this->position += strlen('```');
        } else {
            $_success = false;

            $this->report($this->position, '\'```\'');
        }

        if ($_success) {
            $_value86[] = $this->value;

            $_position84 = $this->position;
            $_cut85 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $this->position = $_position84;

                $_success = $this->parseEOF();
            }

            $this->cut = $_cut85;
        }

        if ($_success) {
            $_value86[] = $this->value;

            $this->value = $_value86;
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

    protected function parseEOL()
    {
        $_position = $this->position;

        if (isset($this->cache['EOL'][$_position])) {
            $_success = $this->cache['EOL'][$_position]['success'];
            $this->position = $this->cache['EOL'][$_position]['position'];
            $this->value = $this->cache['EOL'][$_position]['value'];

            return $_success;
        }

        $_value89 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value89[] = $this->value;

            $_position87 = $this->position;
            $_cut88 = $this->cut;

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
                $this->position = $_position87;
                $this->value = null;
            }

            $this->cut = $_cut88;
        }

        if ($_success) {
            $_value89[] = $this->value;

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
            $_value89[] = $this->value;

            $this->value = $_value89;
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

        $_position90 = $this->position;
        $_cut91 = $this->cut;

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

        $this->position = $_position90;
        $this->cut = $_cut91;

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