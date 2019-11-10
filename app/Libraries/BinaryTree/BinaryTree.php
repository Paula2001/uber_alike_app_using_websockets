<?php
namespace App\Libraries\BinaryTree;
class BinaryTree{
    public $root;

    public function __construct()
    {
        $this->root = null;
    }

    /**
     * function to display the tree
     */
    public function display()
    {
        $this->display_tree($this->root);
    }

    public function display_tree($local_root)
    {
        if ($local_root == null) {
            return;
        }
        $this->display_tree($local_root->leftChild);
        echo $local_root->data;
        echo "\n";
        echo $local_root->driver_id ;
        echo "\n";
        $this->display_tree($local_root->rightChild);
    }

    /**
     * function to insert a new node
     */
    public function insert($key ,$driver_id)
    {
        $newnode = new Node($key ,$driver_id);
        if ($this->root == null) {
            $this->root = $newnode;

            return;
        } else {
            $parent = $this->root;
            $current = $this->root;
            while (true) {
                $parent = $current;
                if ($key == ($this->find_order($key, $current->data))) {
                    $current = $current->leftChild;
                    if ($current == null) {
                        $parent->leftChild = $newnode;
                        return;
                    }
                }else{
                    $current = $current->rightChild;
                    if ($current == null) {
                        $parent->rightChild = $newnode;

                        return;
                    }
                }
            }
        }
    }

    /**
     * function to search a particular Node
     */
    public function find($key)
    {
        $current = $this->root;
        while ($current->data != $key) {
            if ($key == $this->find_order($key, $current->data)) {
                $current = $current->leftChild;
            } else {
                $current = $current->rightChild;
            }
            if ($current == null) {
                return (null);
            }
        }

        return $current;
    }

    public function delete1($key)
    {
        $current = $this->root;
        $parent = $this->root;

        $isLeftChild = true;
        while ($current->data != $key) {
            $parent = $current;
            if ($key == ($this->find_order($key, $current->data))) {
                $current = $current->leftChild;
                $isLeftChild = true;
            } else {
                $current = $current->rightChild;
                $isLeftChild = false;
            }
            if ($current == null) {
                return (null);
            }
        }

        echo "<br/><br/>Node to delete:".$current->data;
        //to delete a leaf node
        if ($current->leftChild == null && $current->rightChild == null) {
            if ($current == $this->root) {
                $this->root = null;
            } else {
                if ($isLeftChild == true) {
                    $parent->leftChild = null;
                } else {
                    $parent->rightChild = null;
                }
            }

            return ($current);
        } else { //to delete a node having a leftChild
            if ($current->rightChild == null) {
                if ($current == $this->root) {
                    $this->root = $current->leftChild;
                } else {
                    if ($isLeftChild == true) {
                        $parent->leftChild = $current->leftChild;
                    } else {
                        $parent->rightChild = $current->leftChild;
                    }
                }

                return ($current);
            } else { //to delete a node having a rightChild
                if ($current->leftChild == null) {
                    if ($current == $this->root) {
                        $this->root = $current->rightChild;
                    } else {
                        if ($isLeftChild == true) {
                            $parent->leftChild = $current->rightChild;
                        } else {
                            $parent->rightChild = $current->rightChild;
                        }
                    }

                    return ($current);
                } else { //to delete a node having both childs
                    $successor = $this->get_successor($current);
                    if ($current == $this->root) {
                        $this->root = $successor;
                    } else {
                        if ($isLeftChild == true) {
                            $parent->leftChild = $successor;
                        } else {
                            $parent->rightChild = $successor;
                        }
                    }
                    $successor->leftChild = $current->leftChild;

                    return ($current);
                }
            }
        }
    }

    /**
     * Function to find the successor node
     */
    public function get_successor($delNode)
    {
        $succParent = $delNode;
        $successor = $delNode;
        $temp = $delNode->rightChild;
        while ($temp != null) {
            $succParent = $successor;
            $successor = $temp;
            $temp = $temp->leftChild;
        }

        if ($successor != $delNode->rightChild) {
            $succParent->leftChild = $successor->rightChild;
            $successor->rightChild = $delNode->rightChild;
        }

        return ($successor);
    }

    /**
     * function to find the order of two strings
     */
    public function find_order($num_1, $num_2)
    {
        while (true) {
            if ($num_1 < $num_2 || ($num_1 == '' && $num_2 == '')) {
                return ($num_1);
            } else {
                if ($num_1 == $num_2) {
                    continue;
                }
                return ($num_2);
            }
        }
    }

    public function is_empty()
    {
        return $this->root === null;
    }
}
