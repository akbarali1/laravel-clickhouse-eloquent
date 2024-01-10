<?php

return new class extends \LaravelClickhouseEloquent\Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        static::write(
            "
            CREATE TABLE IF NOT EXISTS examples (
                created_at DateTime64 DEFAULT now64(),
                f_int Int64,
                f_int2 Int64,
                f_string String
            )
            ENGINE = MergeTree()
            ORDER BY (f_int)
        "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        static::write('DROP TABLE examples');
    }
};
