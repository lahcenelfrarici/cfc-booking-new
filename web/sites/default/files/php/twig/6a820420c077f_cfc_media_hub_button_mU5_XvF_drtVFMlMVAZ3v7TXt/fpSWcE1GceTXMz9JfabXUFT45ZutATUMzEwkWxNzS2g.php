<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:button */
class __TwigTemplate_8c0f51dc61322f2f1ef769ebef7cc796 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'label' => [$this, 'block_label'],
            'icon' => [$this, 'block_icon'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--button"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:button"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:button"));
        $context["variant_classes"] = ["terracotta" => "btn-premium bg-[#9F5434] hover:bg-[#8A4A2E] text-white", "outline-dark" => "border border-neutral-900/15 hover:border-[#9F5434]/50 hover:text-[#9F5434] text-neutral-900 backdrop-blur-sm", "outline-white" => "border border-white/25 hover:bg-white/10 text-white backdrop-blur-sm", "white" => "bg-white text-[#0F6E56] hover:bg-[#E1F5EE] shadow-[0_8px_24px_-8px_rgba(0,0,0,0.25)]"];
        // line 7
        $context["size_classes"] = ["sm" => "px-5 py-2.5 rounded-full text-[13px] font-semibold", "md" => "px-8 py-4 rounded-full text-[14px] font-semibold"];
        // line 11
        $context["classes"] = ((("inline-flex items-center justify-center gap-2 transition-colors group " . (($_v0 = ($context["variant_classes"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0[(($_v1 = ((array_key_exists("variant", $context)) ? (Twig\Extension\CoreExtension::default(($context["variant"] ?? null), "terracotta")) : ("terracotta"))) instanceof \Stringable ? (string) $_v1 : $_v1)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["variant_classes"] ?? null), ((array_key_exists("variant", $context)) ? (Twig\Extension\CoreExtension::default(($context["variant"] ?? null), "terracotta")) : ("terracotta")), [], "array", false, false, true, 11))) . " ") . (($_v2 = ($context["size_classes"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess && in_array($_v2::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v2[(($_v3 = ((array_key_exists("size", $context)) ? (Twig\Extension\CoreExtension::default(($context["size"] ?? null), "md")) : ("md"))) instanceof \Stringable ? (string) $_v3 : $_v3)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["size_classes"] ?? null), ((array_key_exists("size", $context)) ? (Twig\Extension\CoreExtension::default(($context["size"] ?? null), "md")) : ("md")), [], "array", false, false, true, 11)));
        // line 12
        yield "
";
        // line 13
        $context["inner"] = ('' === $tmp = implode('', iterator_to_array((function () use (&$context, $macros, $blocks) {
            // line 14
            yield "  ";
            yield from $this->unwrap()->yieldBlock('label', $context, $blocks);
            // line 15
            yield "  ";
            if ((            $this->unwrap()->hasBlock("icon", $context, $blocks) && (($tmp = Twig\Extension\CoreExtension::trim(            $this->unwrap()->renderBlock("icon", $context, $blocks))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
                yield from $this->unwrap()->yieldBlock('icon', $context, $blocks);
            }
            yield from [];
        })(), false))) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 17
        yield "
";
        // line 18
        if ((($tmp = ($context["href"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 19
            yield "  <a href=\"";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["href"] ?? null), "html", null, true);
            yield "\"";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 19), "html", null, true);
            yield ">";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["inner"] ?? null), "html", null, true);
            yield "</a>
";
        } else {
            // line 21
            yield "  <button type=\"button\"";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 21), "html", null, true);
            yield ">";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["inner"] ?? null), "html", null, true);
            yield "</button>
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["variant", "size", "href", "attributes"]);        yield from [];
    }

    // line 14
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_label(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 15
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_icon(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:button";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  107 => 15,  97 => 14,  85 => 21,  75 => 19,  73 => 18,  70 => 17,  63 => 15,  60 => 14,  58 => 13,  55 => 12,  53 => 11,  51 => 7,  46 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:button", "themes/custom/cfc_media_hub/components/button/button.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 1, "block" => 14, "if" => 15];
        static $filters = ["default" => 11, "trim" => 15, "escape" => 19];
        static $functions = ["block" => 15];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "set", 1 => "block", 2 => "if"],
                [0 => "default", 1 => "trim", 2 => "escape"],
                [0 => "block"],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
