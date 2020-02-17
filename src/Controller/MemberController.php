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
     * @Route("/", name="index",methods="GET")
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->json($memberRepository->findAll());
    }
    //新增資料api
      /**
     * @Route("/new", name="create", methods="POST")
     * 
     */
    public function create(Request $request)
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

    //查看單一筆資料api
    /**
     * @Route("/{id}", name="show", methods="GET")
     */
    public function show($id)
    {
        $member = $this->getDoctrine()->getRepository(Member::class)->find($id);

   

        if($member === null) {
            return $this->json([
                "404"=>"沒有這一筆資料"
                ] 
            );
        }
        return $this->json($member);
    }

    //修改資料的api
    /**
     * @Route("/edit/{id}", name="update",methods="PUT")
     */
    public function update($id,Request $request)
    {
      $data =$request->request->all();

      $doctrine = $this->getDoctrine();

      $member = $doctrine->getRepository(Member::class)->find($id);

    //   dd($member);

      if($request->request->has("name"))
        $member->setName($data["name"]);
      if($request->request->has("ename"))
        $member->setEname($data["ename"]);
      if($request->request->has("phone"))
        $member->setPhone($data["phone"]);
      if($request->request->has("email"))
        $member->setEmail($data["email"]);
      if($request->request->has("sex"))
        $member->setSex($data["sex"]);
      if($request->request->has("city"))
        $member->setCity($data["city"]);
      if($request->request->has("township"))
        $member->setTownship($data["township"]);
      if($request->request->has("postcode"))
        $member->setPostcode($data["postcode"]);
      if($request->request->has("address"))
        $member->setAddress($data["address"]);
      if($request->request->has("notes"))
        $member->setNotes($data["notes"]);

        $manager = $doctrine->getManager();
        $manager->flush();
        
        return new JsonResponse(["200" => "資料修改成功"]);
        // return $this->json(["data" => "ok"]);
    }

     //刪除一筆資料
    /**
     * @Route("/{id}", name="delete",methods="DELETE")
     */
    public function delete(Member $id)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($id);
        $doctrine->flush();

        return new JsonResponse(["200" => "資料刪除成功"]);
    }
}
