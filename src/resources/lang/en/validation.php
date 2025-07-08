<?php

return [
    'custom' => [
        'task' => [
            'title_required' => 'The task title is required',
            'title_max' => 'The task title must not exceed 255 characters',
            'status_required' => 'The task status is required',
            'status_invalid' => 'The task status is invalid',
            'priority_required' => 'The task priority is required',
            'priority_invalid' => 'The task priority is invalid',
            'due_date_date' => 'The due date must be a valid date',
            'assigned_user_required' => 'A member must be assigned to the task',
            'assigned_user_exists' => 'The selected member does not exist',
            'team_required' => 'A team must be selected for the task',
            'team_exists' => 'The selected team does not exist',
            'user_not_in_team' => 'The selected member does not belong to the selected team',
        ],
        'team' => [
            'name_required' => 'The team name is required',
            'name_max' => 'The team name must not exceed 255 characters',
            'description_max' => 'The team description must not exceed 1000 characters',
        ],
    ],
]; 