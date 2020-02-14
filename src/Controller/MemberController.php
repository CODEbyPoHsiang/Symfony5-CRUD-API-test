<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
* @Route("/api/member")
*/

class MemberController extends AbstractController
{
    //顯示全部資料api
    /**
     * @Route("/", name="member",methods="GET")
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->json($memberRepository->findAll());
    }
    //新增資料api
      /**
     * @Route("/new", name="member_new", methods="POST")
     * 
     */
    public function new(Request $request)
    {
        $data = $request->getContent();
        parse_str($data,$data_arr);

        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->submit($data_arr);
        $doctrine =  $this->getDoctrine()->getManager();
        $doctrine->persist($member);
        $doctrine->flush();

      return new JsonResponse(["200" => "資料新增成功"]);

    //   return $this->json($member);
    }
    //查看單一筆資料
    /**
     * @Route("/{id}", name="member_show", methods="GET")
     */
    public function show(Member $member): Response
    {
        return $this->json($member);
    }
    //剩下修改的api
    //https://www.youtube.com/watch?v=TcnQD7C5KK0
    //https://github.com/sadikoff/sf4-api-example/blob/master/src/Controller/RecordController.php







     //刪除一筆資料
    /**
     * @Route("/{id}", methods="DELETE")
     */
    public function delete(Member $id)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($id);
        $doctrine->flush();

        return new JsonResponse(["200" => "資料刪除成功"]);
    }
}
