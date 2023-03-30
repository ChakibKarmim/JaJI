<?php

namespace App\DataFixtures;

use App\Entity\Chapters;
use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class LessonsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {   
        $chapters = $manager->getRepository(Chapters::class)->findall();
        for($j = 0;$j<=17;$j++){
            for($i = 0;$i<=3;$i++){
                $lesson = new Lesson();
                $lesson->setTitle('lesson '.$i+1);
                $lesson->setVideoUrl('video.mp4');
                $lesson->setContent('Logoden biniou degemer mat an penn ar bed gant, pep divalav kemener tarv gouez nag bev c’hi moged, gwerzhañ greiz din respont fur douar dindan . An atav giz eme biniou c’hontrol skiant paper Landreger, c’houlz enor gar Aradon preñv nec’h pluenn veur komz, aer spontus yen skañv beuziñ an ha. Sant-Tegoneg ifern e izel goleiñ fiñval dlead sac’h kurun, skouer puñs wech bruzun start sachañ werenn toull goullo, burzhud da per biz dastum brav diskiant. Marc’h gwer c’hoarzhin ur war c’hoarvezout ganit deiz plad, tabut vatezh c’haol touellañ skorn livañ gavr Kerbabu hon, loen a traoñ gomz pobl stouiñ stlakañ. Goap roll amañ c’horf gwaskañ tog difenn veaj karr volz raok Planvour Roazhon mirout, c’hwevrer gwinegr skuizhañ fourchetez eizh loen kardeur bourc’h hervez  digwener ken. Riskl hervez vourc’h forzh war hor ha da disadorn, kenetre  holl tomm aotrou bruzun bobl c’hleñved nevez hanternoz, eviti enep outañ loer kemmañ brumenn lestr. Riskl zo Malo fazi ret egile heol raok fiziañs bodañ dimerc’her ledan da nevez, roc’h an pad liv ugent Pempoull outañ rak naon gaer Tregastell. Geot war leskiñ troad gador strad toull skouarn brezhoneg, hep waz vihan a Pembo stag ur urzh kouevr, lipat enep verc’h ahont marteze kalz benn. Matezh karrezek ahont da gontell Kernev porpant glas enez, mouchouer kustum pod seul tachenn toullañ bezh gar gwelloc’h, war huanadiñ nec’h paper leziregezh Plouezoc’h vihan. Evidomp egistomp dispign vignonez ur kador reas c’haol yar, kozh giz chadenn kaier bolz mouezh honnezh netra bazh, vantell pont wirionez gwriat vloaz drezañ e.');
                $lesson->setIntro('Logoden. Berrloer. Kelenn. Jod. Dre. E. Brezel. Bloaz. Honnezh. Doñv.');
                $lesson->setChapterId($chapters[$j]);
                $lesson->setDuration(10000000);
                $lesson->setLessonOrder($i+1);
                $manager->persist($lesson);
            }
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ChaptersFixture::class
        ];
    }
}