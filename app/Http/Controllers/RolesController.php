<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRolesRequest;
use App\Http\Requests\UpdateRolesRequest;
use App\Repositories\RolesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Permisos;


class RolesController extends AppBaseController
{
    /** @var  RolesRepository */
    private $rolesRepository;

    public function __construct(RolesRepository $rolesRepo)
    {
        $this->rolesRepository = $rolesRepo;
    }

    /**
     * Display a listing of the Roles.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->rolesRepository->pushCriteria(new RequestCriteria($request));
        $roles = $this->rolesRepository->all();

        return view('roles.index')
            ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new Roles.
     *
     * @return Response
     */
    public function create()
    {
        $permisos = Permisos::pluck('nombre', 'id');

        return view('roles.create', compact('permisos'));
    }

    /**
     * Store a newly created Roles in storage.
     *
     * @param CreateRolesRequest $request
     *
     * @return Response
     */
    public function store(CreateRolesRequest $request)
    {
        $input = $request->all();

        $roles = $this->rolesRepository->create($input);

        Flash::success('Rol guardado exitosamente.');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Roles.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $roles = $this->rolesRepository->findWithoutFail($id);

        if (empty($roles)) {
            Flash::error('Roles not found');

            return redirect(route('roles.index'));
        }

        return view('roles.show')->with('roles', $roles);
    }

    /**
     * Show the form for editing the specified Roles.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $roles = $this->rolesRepository->findWithoutFail($id);

        if (empty($roles)) {
            Flash::error('Rol no encontrado.');

            return redirect(route('roles.index'));
        }

        return view('roles.edit')->with('roles', $roles);
    }

    /**
     * Update the specified Roles in storage.
     *
     * @param  int              $id
     * @param UpdateRolesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRolesRequest $request)
    {
        $roles = $this->rolesRepository->findWithoutFail($id);

        if (empty($roles)) {
            Flash::error('Rol no encontrado.');

            return redirect(route('roles.index'));
        }

        $roles = $this->rolesRepository->update($request->all(), $id);

        Flash::success('Rol actualizado exitosamente.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Roles from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $roles = $this->rolesRepository->findWithoutFail($id);

        if (empty($roles)) {
            Flash::error('Rol no encontrado.');

            return redirect(route('roles.index'));
        }

        $this->rolesRepository->delete($id);

        Flash::success('Rol borrado exitosamente.');

        return redirect(route('roles.index'));
    }
}
