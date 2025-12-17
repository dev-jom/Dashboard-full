<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets_redmine', function (Blueprint $table) {
            $table->string('project')->nullable();
            $table->string('status')->nullable();
            $table->string('tamanho')->nullable();
            $table->string('escopo')->nullable();
            $table->string('subject')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('estimated_hours')->nullable();
            $table->string('spent_hours')->nullable();
            $table->string('tracker')->nullable();
            $table->string('sprint')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets_redmine', function (Blueprint $table) {
            $table->dropColumn([
                'project',
                'status',
                'tamanho',
                'escopo',
                'subject',
                'assigned_to',
                'estimated_hours',
                'spent_hours',
                'tracker',
                'sprint',
            ]);
        });
    }
};
