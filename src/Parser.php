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

    protected function parseEXAMPLE()
    {
        $_position = $this->position;

        if (isset($this->cache['EXAMPLE'][$_position])) {
            $_success = $this->cache['EXAMPLE'][$_position]['success'];
            $this->position = $this->cache['EXAMPLE'][$_position]['position'];
            $this->value = $this->cache['EXAMPLE'][$_position]['value'];

            return $_success;
        }

        $_value19 = array();

        $_position17 = $this->position;
        $_cut18 = $this->cut;

        $this->cut = false;
        $_success = $this->parseANNOTATIONS();

        if (!$_success && !$this->cut) {
            $_success = true;
            $this->position = $_position17;
            $this->value = null;
        }

        $this->cut = $_cut18;

        if ($_success) {
            $annotations = $this->value;
        }

        if ($_success) {
            $_value19[] = $this->value;

            $_success = $this->parseCODE();

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value19[] = $this->value;

            $this->value = $_value19;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$annotations, &$code) {
                return ['annotations' => (array)$annotations, 'code' => $code];
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
            $_value21 = array($this->value);
            $_cut22 = $this->cut;

            while (true) {
                $_position20 = $this->position;

                $this->cut = false;
                $_success = $this->parseANNOTATION_GROUP();

                if (!$_success) {
                    break;
                }

                $_value21[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position20;
                $this->value = $_value21;
            }

            $this->cut = $_cut22;
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

        $_value26 = array();

        $_success = $this->parseANNOTATION_GROUP_START();

        if ($_success) {
            $_value26[] = $this->value;

            $_success = $this->parseANNOTATION();

            if ($_success) {
                $_value24 = array($this->value);
                $_cut25 = $this->cut;

                while (true) {
                    $_position23 = $this->position;

                    $this->cut = false;
                    $_success = $this->parseANNOTATION();

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
                $annotations = $this->value;
            }
        }

        if ($_success) {
            $_value26[] = $this->value;

            $_success = $this->parseANNOTATIONS_GROUP_END();
        }

        if ($_success) {
            $_value26[] = $this->value;

            $this->value = $_value26;
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

    protected function parseANNOTATION_GROUP_START()
    {
        $_position = $this->position;

        if (isset($this->cache['ANNOTATION_GROUP_START'][$_position])) {
            $_success = $this->cache['ANNOTATION_GROUP_START'][$_position]['success'];
            $this->position = $this->cache['ANNOTATION_GROUP_START'][$_position]['position'];
            $this->value = $this->cache['ANNOTATION_GROUP_START'][$_position]['value'];

            return $_success;
        }

        $_value31 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value31[] = $this->value;

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
            $_value31[] = $this->value;

            $_position27 = $this->position;
            $_cut28 = $this->cut;

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
                $this->position = $_position27;
                $this->value = null;
            }

            $this->cut = $_cut28;
        }

        if ($_success) {
            $_value31[] = $this->value;

            $_position29 = $this->position;
            $_cut30 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position29;
                $this->value = null;
            }

            $this->cut = $_cut30;
        }

        if ($_success) {
            $_value31[] = $this->value;

            $this->value = $_value31;
        }

        $this->cache['ANNOTATION_GROUP_START'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ANNOTATION_GROUP_START');
        }

        return $_success;
    }

    protected function parseANNOTATIONS_GROUP_END()
    {
        $_position = $this->position;

        if (isset($this->cache['ANNOTATIONS_GROUP_END'][$_position])) {
            $_success = $this->cache['ANNOTATIONS_GROUP_END'][$_position]['success'];
            $this->position = $this->cache['ANNOTATIONS_GROUP_END'][$_position]['position'];
            $this->value = $this->cache['ANNOTATIONS_GROUP_END'][$_position]['value'];

            return $_success;
        }

        $_value34 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value34[] = $this->value;

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
            $_value34[] = $this->value;

            $_position32 = $this->position;
            $_cut33 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position32;
                $this->value = null;
            }

            $this->cut = $_cut33;
        }

        if ($_success) {
            $_value34[] = $this->value;

            $this->value = $_value34;
        }

        $this->cache['ANNOTATIONS_GROUP_END'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ANNOTATIONS_GROUP_END');
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

        $_value40 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value40[] = $this->value;

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
            $_value40[] = $this->value;

            $_success = $this->parseSTRING();

            if ($_success) {
                $name = $this->value;
            }
        }

        if ($_success) {
            $_value40[] = $this->value;

            $_value36 = array();
            $_cut37 = $this->cut;

            while (true) {
                $_position35 = $this->position;

                $this->cut = false;
                $_success = $this->parseSTRING();

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
                $args = $this->value;
            }
        }

        if ($_success) {
            $_value40[] = $this->value;

            $_position38 = $this->position;
            $_cut39 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $_success = true;
                $this->position = $_position38;
                $this->value = null;
            }

            $this->cut = $_cut39;
        }

        if ($_success) {
            $_value40[] = $this->value;

            $this->value = $_value40;
        }

        if ($_success) {
            $this->value = call_user_func(function () use (&$name, &$args) {
                return [$name, $args];
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

        $_value43 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value43[] = $this->value;

            $_position41 = $this->position;
            $_cut42 = $this->cut;

            $this->cut = false;
            $_success = $this->parseRAW_STRING();

            if (!$_success && !$this->cut) {
                $this->position = $_position41;

                $_success = $this->parseQUOTED_STRING();
            }

            if (!$_success && !$this->cut) {
                $this->position = $_position41;

                $_success = $this->parseEMPTY_STRING();
            }

            $this->cut = $_cut42;

            if ($_success) {
                $string = $this->value;
            }
        }

        if ($_success) {
            $_value43[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value43[] = $this->value;

            $this->value = $_value43;
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

        $_value49 = array();

        if (substr($this->string, $this->position, strlen('"')) === '"') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('"'));
            $this->position += strlen('"');
        } else {
            $_success = false;

            $this->report($this->position, '\'"\'');
        }

        if ($_success) {
            $_value49[] = $this->value;

            $_value47 = array();
            $_cut48 = $this->cut;

            while (true) {
                $_position46 = $this->position;

                $this->cut = false;
                $_position44 = $this->position;
                $_cut45 = $this->cut;

                $this->cut = false;
                $_success = $this->parseESCAPED_QUOTE();

                if (!$_success && !$this->cut) {
                    $this->position = $_position44;

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
                    $this->position = $_position44;

                    $_success = $this->parseRAW_STRING();
                }

                $this->cut = $_cut45;

                if (!$_success) {
                    break;
                }

                $_value47[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position46;
                $this->value = $_value47;
            }

            $this->cut = $_cut48;

            if ($_success) {
                $string = $this->value;
            }
        }

        if ($_success) {
            $_value49[] = $this->value;

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
            $_value49[] = $this->value;

            $this->value = $_value49;
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

        $_position58 = $this->position;

        $_value54 = array();

        $_position52 = $this->position;
        $_cut53 = $this->cut;

        $this->cut = false;
        $_position50 = $this->position;
        $_cut51 = $this->cut;

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
            $this->position = $_position50;

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
            $this->position = $_position50;

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
            $this->position = $_position50;

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
            $this->position = $_position50;

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
            $this->position = $_position50;

            if (substr($this->string, $this->position, strlen('"')) === '"') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('"'));
                $this->position += strlen('"');
            } else {
                $_success = false;

                $this->report($this->position, '\'"\'');
            }
        }

        $this->cut = $_cut51;

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position52;
        $this->cut = $_cut53;

        if ($_success) {
            $_value54[] = $this->value;

            if ($this->position < strlen($this->string)) {
                $_success = true;
                $this->value = substr($this->string, $this->position, 1);
                $this->position += 1;
            } else {
                $_success = false;
            }
        }

        if ($_success) {
            $_value54[] = $this->value;

            $this->value = $_value54;
        }

        if ($_success) {
            $_value56 = array($this->value);
            $_cut57 = $this->cut;

            while (true) {
                $_position55 = $this->position;

                $this->cut = false;
                $_value54 = array();

                $_position52 = $this->position;
                $_cut53 = $this->cut;

                $this->cut = false;
                $_position50 = $this->position;
                $_cut51 = $this->cut;

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
                    $this->position = $_position50;

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
                    $this->position = $_position50;

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
                    $this->position = $_position50;

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
                    $this->position = $_position50;

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
                    $this->position = $_position50;

                    if (substr($this->string, $this->position, strlen('"')) === '"') {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen('"'));
                        $this->position += strlen('"');
                    } else {
                        $_success = false;

                        $this->report($this->position, '\'"\'');
                    }
                }

                $this->cut = $_cut51;

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position52;
                $this->cut = $_cut53;

                if ($_success) {
                    $_value54[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value54[] = $this->value;

                    $this->value = $_value54;
                }

                if (!$_success) {
                    break;
                }

                $_value56[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position55;
                $this->value = $_value56;
            }

            $this->cut = $_cut57;
        }

        if ($_success) {
            $this->value = strval(substr($this->string, $_position58, $this->position - $_position58));
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

        $_value66 = array();

        $_success = $this->parseCODE_START();

        if ($_success) {
            $_value66[] = $this->value;

            $_position65 = $this->position;

            $_value63 = array();
            $_cut64 = $this->cut;

            while (true) {
                $_position62 = $this->position;

                $this->cut = false;
                $_value61 = array();

                $_position59 = $this->position;
                $_cut60 = $this->cut;

                $this->cut = false;
                $_success = $this->parseCODE_END();

                if (!$_success) {
                    $_success = true;
                    $this->value = null;
                } else {
                    $_success = false;
                }

                $this->position = $_position59;
                $this->cut = $_cut60;

                if ($_success) {
                    $_value61[] = $this->value;

                    if ($this->position < strlen($this->string)) {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, 1);
                        $this->position += 1;
                    } else {
                        $_success = false;
                    }
                }

                if ($_success) {
                    $_value61[] = $this->value;

                    $this->value = $_value61;
                }

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
                $this->value = strval(substr($this->string, $_position65, $this->position - $_position65));
            }

            if ($_success) {
                $code = $this->value;
            }
        }

        if ($_success) {
            $_value66[] = $this->value;

            $_success = $this->parseCODE_END();
        }

        if ($_success) {
            $_value66[] = $this->value;

            $this->value = $_value66;
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

        $_value67 = array();

        if (strtolower(substr($this->string, $this->position, strlen('```php'))) === strtolower('```php')) {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```php'));
            $this->position += strlen('```php');
        } else {
            $_success = false;

            $this->report($this->position, '\'```php\'');
        }

        if ($_success) {
            $_value67[] = $this->value;

            $_success = $this->parseEOL();
        }

        if ($_success) {
            $_value67[] = $this->value;

            $this->value = $_value67;
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

        $_value70 = array();

        if (substr($this->string, $this->position, strlen('```')) === '```') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('```'));
            $this->position += strlen('```');
        } else {
            $_success = false;

            $this->report($this->position, '\'```\'');
        }

        if ($_success) {
            $_value70[] = $this->value;

            $_position68 = $this->position;
            $_cut69 = $this->cut;

            $this->cut = false;
            $_success = $this->parseEOL();

            if (!$_success && !$this->cut) {
                $this->position = $_position68;

                $_success = $this->parseEOF();
            }

            $this->cut = $_cut69;
        }

        if ($_success) {
            $_value70[] = $this->value;

            $this->value = $_value70;
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

        $_value73 = array();

        $_success = $this->parse_();

        if ($_success) {
            $_value73[] = $this->value;

            $_position71 = $this->position;
            $_cut72 = $this->cut;

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
                $this->position = $_position71;
                $this->value = null;
            }

            $this->cut = $_cut72;
        }

        if ($_success) {
            $_value73[] = $this->value;

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
            $_value73[] = $this->value;

            $this->value = $_value73;
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

        $_position74 = $this->position;
        $_cut75 = $this->cut;

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

        $this->position = $_position74;
        $this->cut = $_cut75;

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

        $_value79 = array();
        $_cut80 = $this->cut;

        while (true) {
            $_position78 = $this->position;

            $this->cut = false;
            $_position76 = $this->position;
            $_cut77 = $this->cut;

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
                $this->position = $_position76;

                if (substr($this->string, $this->position, strlen("\t")) === "\t") {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen("\t"));
                    $this->position += strlen("\t");
                } else {
                    $_success = false;

                    $this->report($this->position, '"\\t"');
                }
            }

            $this->cut = $_cut77;

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