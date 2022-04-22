<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'trainer_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'title' => 'Muller នឹង​បន្ត​កុងត្រា​ថ្មី​ជា​មួយ​ Bayern'.' - '.rand(1,100),
            'body'=> '<p>&nbsp;</p><p>ខ្សែ​ប្រយុទ្ធ​ Thomas Muller នឹង​បន្ត​កុងត្រា​ថ្មី​ជា​មួយ​ក្លឹប​ Bayern Munich បន្ត​ទៀត​នៅ​ពេល​ខាង​មុខ​នេះ​ ខណៈ​កុងត្រា​របស់​គេ​ជា​មួយ​នឹង​ក្លឹប​នេះ​នឹង​បញ្ចប់​នៅ​ថ្ងៃ​ទី​៣០ ខែ​មិថុនា ឆ្នាំ​២០២៣។ បើ​យោង​តាម​កំពូល​អ្នកកាសែត​ Fabrizio Romano ។</p><p>&nbsp;</p><p>បើ​តាម​ប្រភព​ខាង​លើ​នេះ​ ទាំង​ Muller និង​ខាង​ក្លឹប​ Bayern សុទ្ធ​តែ​ធ្លាប់​និយាយ​ទៅ​កាន់​សារព័ត៌មាន​ Bild ថា​ ភាគី​ទាំង​ពីរ​ចរចា​កុងត្រា​ថ្មី​បន្ត​ទៀត​ដោយ​មាន​លក្ខណៈ​វិជ្ជមាន​ ដោយ​ភាគី​ទាំង​ពីរ​សុទ្ធ​តែ​ចង់​បន្ត​កុងត្រា​ថ្មី​ ដូច្នេះ​ទាមទារ​តែ​ពេល​វេលា​សមស្រប​ប៉ុណ្ណោះ​ ការ​ចរចា​កុងត្រា​ថ្មី​នេះ​នឹង​បិទ​បញ្ចប់​។</p><p>បើ​តាម​ <a href="https://www.bavarianfootballworks.com/2022/4/18/23029972/bayern-munich-thomas-muller-20-million-2025-neuer-lewandowski-transfer-nagelsmann-gnabry-brazzo-kahn" target="_blank">Bavarian Football Works</a> ក្លឹប​ Bayern បាន​ផ្ដល់​កុងត្រា​ដល់​ Muller រហូត​ដល់​ឆ្នាំ​២០២៥ ជា​មួយ​នឹង​ប្រាក់​ពលកម្ម​ជិត​ ២២លាន​ដុល្លារ​ក្នុង​មួយ​ឆ្នាំ​ ហើយ​ខ្សែ​ប្រយុទ្ធ​រូប​នេះ​ក៏​ពេញ​ចិត្ត​នឹង​ការ​ផ្ដល់​ឲ្យ​មួយ​នេះ​ផង​ដែរ​។</p><p>Muller បាន​មក​លេង​ឲ្យ​ក្រុម​ឈុត​ធំ​ Bayern តាំង​ពី​ឆ្នាំ​២០០៩មក ដោយ​ចូល​លេង​បាន​ ៦២៣ប្រកួត​ ស៊ុត​ចូល​បាន​ ២២៦គ្រាប់​៕</p>',
            'image'=> '4153b5e54cac2e812c1ee6d26110bac0.jpg',
            'location' => 1
        ];
    }
}
