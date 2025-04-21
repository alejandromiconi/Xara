<?php

namespace App\Constants;

class Constants
{
    public const 
        FT_SELECT = "select",
        FT_SEARCH = "search",
        FT_CHECKBOX = "checkbox",
        FT_FILE = "file",
        FT_UDC = "udc",
        FT_HIDDEN = "hidden",
        FT_TEXT = "text",
        FT_DATE = "date",
        FT_DATETIME = "timestamp",
        FT_FLOAT = "float",
        FT_INTEGER = "integer"
        ;

    public const
        MAX_LENGTH = 50,
        DATETIME_FORMAT = "Y-m-d H:i:s",
        EXPORT_LIMITS = 1000, // Por el timeout de la consulta
        PAGINATION = 20;

    public const
        ACTION_CREATE = "create",
        ACTION_VIEW = "view",
        ACTION_EDIT = "edit",
        ACTION_DELETE = "delete",
        ACTION_COPY = "copy";

    public const
        PART_HEADER = 0,
        PART_BULK = 1,
        PART_DETAIL = 9;

    public const
        ID = "id",
        FD_COMPANY = "company_id",
        FD_CREATED_AT = "created_at",
        FD_UPDATED_AT = "updated_at";


    public static function hasLabel($type) {
        return !in_array($type, [
            self::FT_CHECKBOX,
            self::FT_HIDDEN,
        ]);
    }


    public static function readOnlyColumns()
    {
        return [
            self::ID,
            self::FD_CREATED_AT,
            self::FD_UPDATED_AT,
        ];
    }

    public static function timestampColumns()
    {
        return [
            self::FD_CREATED_AT,
            self::FD_UPDATED_AT,
        ];
    }

}