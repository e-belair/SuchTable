<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 19:20
 */

namespace SuchTable\Element;


use SuchTable\Element;
use SuchTable\Exception\InvalidArgumentException;

abstract class AbstractList extends Element
{
    public function prepare()
    {
        if ($this->isPrepared === true) {
            return $this;
        }
        parent::prepare();

        if (!$getter = $this->getOption('getter')) {
            throw new InvalidArgumentException(
                sprintf("'getter' option is missing on '%s' element", $this->getName())
            );
        }

        $content = [];
        if ($value = $this->getValue()) {
            foreach ($value as $line) {
                if (is_array($line)) {
                    $li = $line[$getter];
                } elseif (is_object($line)) {
                    $getter = 'get' . ucfirst($getter);
                    try {
                        $li = $line->$getter();
                    } catch (\Exception $e) {
                        throw new InvalidArgumentException(
                            sprintf('object has to be accessible with "%s" method', $getter)
                        );
                    }
                } else {
                    throw new InvalidArgumentException(
                        sprintf("Invalid type of data, expected array or object found %s", gettype($line))
                    );
                }
                $content[] = $li;
            }

            $this->setValue($content);
        }
    }
}
