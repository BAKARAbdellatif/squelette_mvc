<?php

class Controller
{

    public function __construct()
    {
    }


    public function getRequestData($key, $default = '')
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        return $default;
    }

    public function requestHas($key)
    {
        if (isset($_REQUEST[$key])) {
            return true;
        }
        return false;
    }

    public function isRequestValueNotEmpty($key)
    {
        if (!empty($_REQUEST[$key])) {
            return true;
        } else {
            false;
        }
    }

    public function view($path, $data = [], $is_auth = true)
    {
        extract($data);
        $path = "/" . str_replace('.', '/', $path) . ".php";
        if ($is_auth) {
            include __DIR__ . "/../Views/base.php";
        } else {
            include __DIR__ . "/../Views$path";
        }
    }

    function getPaginate($current_page, $total_pages)
    {
        $pagination_html = '<nav aria-label="Page navigation"><ul class="pagination">';

        // First page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page <= 1 ? ' disabled' : '') . '"><a class="page-link text-info" href="?page=1">First</a></li>';

        // Previous page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page <= 1 ? ' disabled' : '') . '"><a class="page-link text-info" href="?page=' . ($current_page - 1) . '">Previous</a></li>';

        // Page links with ellipsis
        $start_page = max(1, $current_page - 2);
        $end_page = min($total_pages, $current_page + 3);
        if ($start_page > 1) $pagination_html .= '<li class="page-item disabled"><a class="page-link">...</a></li>';
        for ($i = $start_page; $i <= $end_page; $i++) {
            $active = ($current_page == $i) ? ' bg-info' : '';
            $text_color = ($current_page == $i) ? "text-white " : "text-info ";
            $pagination_html .= '<li class="page-item text-' . $text_color . '"><a class="page-link ' . $text_color . $active . '" href="?page=' . $i . '">' . $i . '</a></li>';
        }
        if ($end_page < $total_pages) $pagination_html .= '<li class="page-item disabled"><a class="page-link">...</a></li>';

        // Next page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page >= $total_pages ? ' disabled' : '') . '"><a class="page-link text-info" href="?page=' . ($current_page + 1) . '">Next</a></li>';

        // Last page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page >= $total_pages ? ' disabled' : '') . '"><a class="page-link text-info" href="?page=' . $total_pages . '">Last</a></li>';

        $pagination_html .= '</ul></nav>';

        return $pagination_html;
    }

    function getAjaxPaginate($current_page, $total_pages)
    {
        $pagination_html = '<nav aria-label="Page navigation"><ul class="pagination">';

        // First page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page <= 1 ? ' disabled' : '') . '"><a class="page-link text-info" href="javascript:void(0);" onclick="getPage(1)">First</a></li>';

        // Previous page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page <= 1 ? ' disabled' : '') . '"><a class="page-link text-info" href="javascript:void(0);" onclick="getPage(' . ($current_page - 1) . ')">Previous</a></li>';

        // Page links with ellipsis
        $start_page = max(1, $current_page - 2);
        $end_page = min($total_pages, $current_page + 3);
        if ($start_page > 1) $pagination_html .= '<li class="page-item disabled"><a class="page-link">...</a></li>';
        for ($i = $start_page; $i <= $end_page; $i++) {
            $active = ($current_page == $i) ? ' bg-info' : '';
            $text_color = ($current_page == $i) ? "text-white " : "text-info ";
            $pagination_html .= '<li class="page-item text-' . $text_color . '"><a class="page-link ' . $text_color . $active . '"  href="javascript:void(0);" onclick="getPage(' . ($i) . ')">' . $i . '</a></li>';
        }
        if ($end_page < $total_pages) $pagination_html .= '<li class="page-item disabled"><a class="page-link">...</a></li>';

        // Next page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page >= $total_pages ? ' disabled' : '') . '"><a class="page-link text-info" href="javascript:void(0);" onclick="getPage(' . ($current_page + 1) . ')">Next</a></li>';

        // Last page link
        $pagination_html .= '<li class="page-item text-info' . ($current_page >= $total_pages ? ' disabled' : '') . '"><a class="page-link text-info" href="javascript:void(0);" onclick="getPage(' . $total_pages . ')">Last</a></li>';

        $pagination_html .= '</ul></nav>';

        return $pagination_html;
    }

    public function validateRequest($params)
    {
        $request = array();
        $keys = array_keys($params);
        $errors_count = 0;
        foreach ($keys as $key) {
            $conditions = explode("|", $params[$key]);
            $data = $this->getRequestData($key);
            $error = "";
            foreach ($conditions as $condition) {
                if (strpos($condition, "confirm") !== false) {
                    $exploded_condition = explode(":", $condition);
                    $confirm_key = $exploded_condition[1];
                    $data_to_confirm = $this->getRequestData($confirm_key);
                } else {
                    $data_to_confirm = null;
                }
                if (!$this->validate($data, $condition, $data_to_confirm)) {
                    $error = $this->getValidationMessage($key, $condition);
                    $errors_count++;
                    break;
                }
            }
            $request[$key] = ["value" => $data, "error" => $error];
        }
        $request["errors"] = $errors_count;
        return $request;
    }

    public function validate($value, $condition, $other_data)
    {
        if (strpos($condition, ":") !== false) {
            if (strpos($condition, "unique") !== false) {
                $exploded_condition = explode(":", $condition);
                $model_key = (isset($exploded_condition[1])) ? $exploded_condition[1] : "";
                $exploded_model_key = explode(".", $model_key);
                $model = $exploded_model_key[0];
                $key = $exploded_model_key[1];
                if ($model != "") {
                    require_once __DIR__ . "/../Models/$model.php";
                    $model = ucfirst($model);
                    $model = new $model();
                    return $model->isUnique($key, $value);
                }
            }
            if (strpos($condition, "minLength") !== false) {
                $exploded_condition = explode(":", $condition);
                $nbr = $exploded_condition[1];
                if (strlen($value) < $nbr) {
                    return false;
                }
            }
            if (strpos($condition, "confirm") !== false) {
                if ($value != $other_data) {
                    return false;
                }
            }
        } else {
            if ($condition == "required" and $value == "") {
                return false;
            } elseif ($condition == "email" and !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return false;
            } elseif ($condition == "onlyDigit" and !ctype_digit($value)) {
                return false;
            }
        }
        return true;
    }

    public function getValidationMessage($key, $condition)
    {
        $nbr = 0;
        if (strpos($condition, "confirm:") !== false) {
            $nbr = str_replace("confirm:", "", $condition);
            $condition = "confirm";
        }
        if (strpos($condition, "minLength:") !== false) {
            $nbr = str_replace("minLength:", "", $condition);
            $condition = "minLength";
        }
        if (strpos($condition, "unique:") !== false) {
            $condition = "unique";
        }

        $messages = [
            "required" => "Ce champ est obligatoire!",
            "email" => "Veuillez saisir une adresse e-mail valide!",
            "unique" => "La valeur que vous avez saisie pour ce champ existe déjà dans la base de données. Veuillez saisir une autre valeur!",
            "minLength" => "Ce champ doit contenir au moins $nbr caractères!",
            "confirm" => "La confirmation du mot de passe ne correspond pas au mot de passe!",
            "onlyDigit" => "Entrez uniquement des chiffres!"
        ];
        return $messages[$condition];
    }

    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            return true;
        }
        return false;
    }

    public function isGet()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            return true;
        }
        return false;
    }

    public function getDefaultPage($privileges)
    {
        if (in_array("ADMIN_READ", $privileges)) {
            header("Location: /admin/roles");
        } elseif (in_array("PRISE_EN_CHARGE_WRITE", $privileges)) {
            header("Location: /priseencharge/index");
        } elseif (in_array("REGISSEUR_READ", $privileges)) {
            header("Location: /regisseur/index");
        } elseif (in_array("ETABLISSEMENT_READ", $privileges)) {
            header("Location: /Etablissement/index");
        } elseif (in_array("CONTROLE_READ", $privileges)) {
            header("Location: /controle/index");
        } elseif (in_array("VALIDATION_READ", $privileges)) {
            header("Location: /validation/index");
        } elseif (in_array("BO_READ", $privileges)) {
            header("Location: /bo/index");
        } elseif (in_array("REMISE_READ", $privileges)) {
            header("Location: /remise/index");
        } elseif (in_array("NOTE_READ", $privileges)) {
            header("Location: /note/index");
        }
    }
}
