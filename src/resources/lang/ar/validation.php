<?php

return [
    'custom' => [
        'task' => [
            'title_required' => 'عنوان المهمة مطلوب',
            'title_max' => 'عنوان المهمة يجب أن لا يتجاوز 255 حرف',
            'status_required' => 'حالة المهمة مطلوبة',
            'status_invalid' => 'حالة المهمة غير صحيحة',
            'priority_required' => 'أولوية المهمة مطلوبة',
            'priority_invalid' => 'أولوية المهمة غير صحيحة',
            'due_date_date' => 'تاريخ الاستحقاق يجب أن يكون تاريخ صحيح',
            'assigned_user_required' => 'يجب تحديد عضو للمهمة',
            'assigned_user_exists' => 'العضو المحدد غير موجود',
            'team_required' => 'يجب تحديد فريق للمهمة',
            'team_exists' => 'الفريق المحدد غير موجود',
            'user_not_in_team' => 'العضو المحدد لا ينتمي إلى الفريق المحدد',
        ],
        'team' => [
            'name_required' => 'اسم الفريق مطلوب',
            'name_max' => 'اسم الفريق يجب أن لا يتجاوز 255 حرف',
            'description_max' => 'وصف الفريق يجب أن لا يتجاوز 1000 حرف',
        ],
    ],
]; 